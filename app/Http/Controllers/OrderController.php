<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ClubGuest;
use App\Models\ClubTable;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function showTable(string $token)
    {
        $table = ClubTable::where('qr_token', $token)
            ->orWhere('table_number', $token)
            ->firstOrFail();

        session(['current_table_id' => $table->id]);

        return redirect()->route('home', ['table' => $table->table_number]);
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

        $guest->update(['club_table_id' => $table->id]);
        session([
            'guest_id' => $guest->id,
            'guest_code' => $guest->guest_code,
            'guest_name' => $guest->name,
            'current_table_id' => $table->id,
            'current_table_number' => $table->table_number,
        ]);

        return redirect()->route('home', ['table' => $table->table_number])
            ->with('success', "Hoş geldiniz {$guest->name}! {$table->table_number} masasına başarıyla bağlandınız.");
    }

    public function leaveTable()
    {
        session()->forget(['guest_id', 'guest_code', 'guest_name']);
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

        if (!$table) {
            return response()->json([
                'success' => false,
                'message' => 'Masa bilgisi doğrulanamadı.'
            ], 400);
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
            'message' => 'Siparişiniz başarıyla alındı ve barmen / servis ekibine iletildi.',
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
}
