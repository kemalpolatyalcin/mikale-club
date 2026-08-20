<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ClubGuest;
use App\Models\ClubTable;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function showTable(Request $request, string $token)
    {
        $table = ClubTable::where('qr_token', $token)
            ->orWhere('table_number', $token)
            ->first();

        if (!$table) {
            return redirect()->route('home')->with('error', 'Geçersiz masa bağlantısı.');
        }

        if (!$table->isTokenValid($token)) {
            return redirect()->route('home')->with('error', 'Masa QR oturumunun süresi dolmuş veya masa kapatılmıştır. Lütfen masadaki güncel QR kodu okutunuz.');
        }

        session([
            'current_table_id' => $table->id,
            'current_table_number' => $table->table_number,
            'current_table_token' => $table->qr_token,
        ]);

        return redirect()->route('home', ['table' => $table->table_number, 'token' => $table->qr_token]);
    }

    public function getTableMenuApi(Request $request, string $tableNumber)
    {
        $token = $request->query('token');
        $table = ClubTable::where('table_number', $tableNumber)->first();

        if (!$table) {
            return response()->json([
                'success' => false,
                'message' => 'Belirtilen masa bulunamadı.',
            ], 404);
        }

        if (!$table->isTokenValid($token)) {
            return response()->json([
                'success' => false,
                'message' => 'Masa QR token süresi dolmuş veya masa kapatılmıştır. Eski bağlantılar reddedilmiştir.',
            ], 403);
        }

        $categories = Category::where('is_active', true)
            ->with(['activeProducts'])
            ->orderBy('sort_order')
            ->get();

        return response()->json([
            'success' => true,
            'table' => $table->table_number,
            'token_expires_at' => $table->token_expires_at ? $table->token_expires_at->toIso8601String() : null,
            'categories' => $categories,
        ]);
    }

    public function joinTable(Request $request)
    {
        $validated = $request->validate([
            'guest_code' => 'required|string',
            'table_number' => 'required|string',
        ]);

        $guest = ClubGuest::where('guest_code', strtoupper(trim($validated['guest_code'])))
            ->where('status', 'active')
            ->first();

        if (!$guest) {
            return back()->with('error', 'Geçersiz veya süresi dolmuş VIP Misafir Kodu. Lütfen resepsiyona danışınız.');
        }

        $table = ClubTable::where('table_number', $validated['table_number'])
            ->orWhere('qr_token', $validated['table_number'])
            ->first();

        if (!$table) {
            return back()->with('error', 'Belirtilen masa bulunamadı.');
        }

        if ($table->token_expires_at && $table->token_expires_at->isPast()) {
            return back()->with('error', 'Masaya ait QR oturum süresi dolmuştur. Lütfen yeni QR kod isteyiniz.');
        }

        $guest->update(['club_table_id' => $table->id]);
        session([
            'guest_id' => $guest->id,
            'guest_code' => $guest->guest_code,
            'guest_name' => $guest->name,
            'current_table_id' => $table->id,
            'current_table_number' => $table->table_number,
            'current_table_token' => $table->qr_token,
        ]);

        return redirect()->route('home', ['table' => $table->table_number, 'token' => $table->qr_token])
            ->with('success', "Hoş geldiniz {$guest->name}! {$table->table_number} masasına başarıyla bağlandınız.");
    }

    public function leaveTable()
    {
        session()->forget(['guest_id', 'guest_code', 'guest_name', 'current_table_id', 'current_table_number', 'current_table_token']);
        return redirect()->route('home')->with('success', 'Masa oturumunuz kapatıldı.');
    }

    public function storeOrder(Request $request)
    {
        $guestId = session('guest_id');
        $tableNumber = $request->input('table_number');

        if (!$guestId) {
            return response()->json([
                'success' => false,
                'message' => 'Sipariş vermek için lütfen önce resepsiyondan verilen VIP Kodunuz ile masaya giriş yapınız.'
            ], 401);
        }

        $guest = ClubGuest::where('id', $guestId)->where('status', 'active')->first();
        if (!$guest) {
            return response()->json([
                'success' => false,
                'message' => 'Aktif misafir oturumunuz bulunamadı. Lütfen tekrar giriş yapınız.'
            ], 401);
        }

        $table = ClubTable::where('table_number', $tableNumber)
            ->orWhere('id', session('current_table_id'))
            ->first();

        if (!$table || !$table->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'Masa bilgisi doğrulanamadı veya masa kapalı.'
            ], 400);
        }

        if ($table->token_expires_at && $table->token_expires_at->isPast()) {
            return response()->json([
                'success' => false,
                'message' => 'Masa oturumunun geçerlilik süresi dolmuştur. Lütfen resepsiyondan yeni oturum alınız.'
            ], 403);
        }

        if (config('mikale.gps_verification_enabled')) {
            $userLat = $request->input('latitude');
            $userLon = $request->input('longitude');

            if ($userLat === null || $userLon === null) {
                return response()->json([
                    'success' => false,
                    'message' => 'Sipariş verebilmek için konum (GPS) erişimine izin vermeniz gerekmektedir.'
                ], 403);
            }

            $venueLat = config('mikale.venue_latitude', 41.042200);
            $venueLon = config('mikale.venue_longitude', 29.006700);
            $maxDistance = config('mikale.max_distance_meters', 20.0);

            $distance = $this->calculateDistanceInMeters((float)$userLat, (float)$userLon, $venueLat, $venueLon);

            if ($distance > $maxDistance) {
                return response()->json([
                    'success' => false,
                    'message' => "Sipariş reddedildi: Club/restoran sınırları dışındasınız. İzin verilen maksimum mesafe {$maxDistance} metredir (Ölçülen mesafe: " . round($distance, 1) . "m)."
                ], 403);
            }
        }

        if (config('mikale.turnstile.enabled')) {
            $turnstileToken = $request->input('turnstile_token');
            $secretKey = config('mikale.turnstile.secret_key');

            if ($turnstileToken && $secretKey && $secretKey !== '1x0000000000000000000000000000000AA') {
                try {
                    $verifyResponse = Http::asForm()->timeout(5)->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
                        'secret' => $secretKey,
                        'response' => $turnstileToken,
                        'remoteip' => $request->ip(),
                    ]);

                    if (!$verifyResponse->json('success')) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Bot koruması (Cloudflare Turnstile) doğrulaması başarısız oldu.'
                        ], 403);
                    }
                } catch (\Exception $e) {
                }
            }
        }

        $items = $request->input('items', []);
        if (empty($items)) {
            return response()->json([
                'success' => false,
                'message' => 'Sepetiniz boş.'
            ], 400);
        }

        $orderNumber = 'ORD-' . strtoupper(Str::random(6));
        $totalAmount = 0;

        $order = Order::create([
            'order_number' => $orderNumber,
            'club_table_id' => $table->id,
            'club_guest_id' => $guest->id,
            'status' => 'pending',
            'total_amount' => 0,
            'guest_note' => $request->input('note'),
        ]);

        foreach ($items as $item) {
            $product = Product::find($item['product_id']);
            if ($product && $product->is_available) {
                $qty = max(1, (int)$item['quantity']);
                $itemTotal = $product->price * $qty;
                $totalAmount += $itemTotal;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $qty,
                    'unit_price' => $product->price,
                    'total_price' => $itemTotal,
                    'special_instructions' => $item['notes'] ?? null,
                    'status' => 'pending',
                ]);
            }
        }

        $order->update(['total_amount' => $totalAmount]);

        return response()->json([
            'success' => true,
            'message' => 'Siparişiniz başarıyla alındı ve servis ekibine iletildi.',
            'order_number' => $orderNumber,
            'total' => number_format($totalAmount, 0, ',', '.') . ' ₺'
        ]);
    }

    public function getTableOrders(Request $request, string $tableNumber)
    {
        $table = ClubTable::where('table_number', $tableNumber)->first();
        if (!$table) {
            return response()->json(['orders' => []]);
        }

        $orders = Order::with(['guest', 'items.product'])
            ->where('club_table_id', $table->id)
            ->latest()
            ->take(15)
            ->get();

        $activeTableGuests = ClubGuest::where('club_table_id', $table->id)
            ->where('status', 'active')
            ->select('id', 'name', 'guest_code')
            ->get();

        return response()->json([
            'table' => $table->table_number,
            'guests' => $activeTableGuests,
            'orders' => $orders
        ]);
    }

    private function calculateDistanceInMeters(float $lat1, float $lon1, float $lat2, float $lon2): float
    {
        $earthRadius = 6371000;

        $latFrom = deg2rad($lat1);
        $lonFrom = deg2rad($lon1);
        $latTo = deg2rad($lat2);
        $lonTo = deg2rad($lon2);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
            cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));

        return $angle * $earthRadius;
    }
}
