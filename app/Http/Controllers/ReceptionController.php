<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Category;
use App\Models\ClubGuest;
use App\Models\ClubTable;
use App\Models\Order;
use App\Models\Product;
use App\Models\WaiterCall;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ReceptionController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('reception.index');
        }

        return view('reception.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('reception.index'))->with('success', 'Resepsiyon portalına başarıyla giriş yapıldı.');
        }

        return back()->withErrors([
            'email' => 'E-posta adresi veya şifre hatalı.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('reception.login')->with('success', 'Oturum başarıyla kapatıldı.');
    }

    public function index(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('reception.login');
        }

        $tab = $request->query('tab', 'dashboard');
        $search = $request->query('search');

        $activeGuests = ClubGuest::with(['table', 'orders.items.product'])
            ->where('status', 'active')
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('guest_code', 'like', "%{$search}%")
                      ->orWhere('phone', 'like', "%{$search}%");
                });
            })
            ->latest('check_in_at')
            ->get();

        $allGuests = ClubGuest::with('table')
            ->latest()
            ->take(30)
            ->get();

        $recentCheckouts = ClubGuest::with('table')
            ->where('status', 'checked_out')
            ->latest('check_out_at')
            ->take(12)
            ->get();

        $tables = ClubTable::with(['activeGuests', 'orders.items'])
            ->orderBy('table_number')
            ->get();

        $liveOrders = Order::with(['guest', 'table', 'items.product'])
            ->latest()
            ->take(30)
            ->get();

        $categories = Category::withCount('products')
            ->with(['products' => function ($q) {
                $q->orderBy('sort_order')->orderBy('id');
            }])
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        $products = Product::with('category')
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            })
            ->orderBy('category_id')
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        $bills = Bill::with(['guest', 'table'])
            ->latest()
            ->take(20)
            ->get();

        $totalActiveSpent = $activeGuests->sum(function ($guest) {
            return $guest->totalSpent();
        });

        $totalBillsRevenue = Bill::where('status', 'paid')->sum('total_amount');
        $pendingOrdersCount = Order::whereIn('status', ['pending', 'preparing'])->count();
        $totalProductsCount = Product::count();
        $totalCategoriesCount = Category::count();
        $activeTablesCount = ClubTable::whereHas('activeGuests')->count();
        $todayGuestsCount = ClubGuest::whereDate('check_in_at', now()->today())->count();

        $waiterCalls = WaiterCall::with(['table', 'guest', 'order.items.product'])
            ->latest()
            ->take(50)
            ->get();
        $pendingWaiterCallsCount = WaiterCall::where('status', 'pending')->count();

        return view('reception.index', compact(
            'activeGuests',
            'allGuests',
            'recentCheckouts',
            'tables',
            'liveOrders',
            'categories',
            'products',
            'bills',
            'totalActiveSpent',
            'totalBillsRevenue',
            'pendingOrdersCount',
            'totalProductsCount',
            'totalCategoriesCount',
            'activeTablesCount',
            'todayGuestsCount',
            'waiterCalls',
            'pendingWaiterCallsCount',
            'search',
            'tab'
        ));
    }

    public function store(Request $request)
    {
        if (!Auth::check()) return redirect()->route('reception.login');

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'guest_code' => 'nullable|string|max:50|unique:club_guests,guest_code',
            'phone' => 'nullable|string|max:50',
            'club_table_id' => 'nullable|exists:club_tables,id',
        ]);

        if (!empty($validated['guest_code'])) {
            $code = strtoupper(trim($validated['guest_code']));
        } else {
            $code = 'VIP-' . strtoupper(Str::random(4));
            while (ClubGuest::where('guest_code', $code)->exists()) {
                $code = 'VIP-' . strtoupper(Str::random(4));
            }
        }

        ClubGuest::create([
            'guest_code' => $code,
            'name' => $validated['name'],
            'phone' => $validated['phone'] ?? '0532 555 19 23',
            'club_table_id' => $validated['club_table_id'] ?? null,
            'status' => 'active',
            'check_in_at' => now(),
        ]);

        return redirect()->route('reception.index', ['tab' => 'guests'])->with('success', "Misafir {$validated['name']} ({$code}) başarıyla kaydedildi.");
    }

    public function updateGuest(Request $request, ClubGuest $guest)
    {
        if (!Auth::check()) return redirect()->route('reception.login');

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'guest_code' => 'required|string|max:50|unique:club_guests,guest_code,' . $guest->id,
            'phone' => 'nullable|string|max:50',
            'club_table_id' => 'nullable|exists:club_tables,id',
            'status' => 'required|in:active,checked_out',
        ]);

        $validated['guest_code'] = strtoupper(trim($validated['guest_code']));

        $guest->update($validated);

        return redirect()->route('reception.index', ['tab' => 'guests'])->with('success', "Misafir {$guest->name} ({$guest->guest_code}) bilgileri güncellendi.");
    }

    public function deleteGuest(ClubGuest $guest)
    {
        if (!Auth::check()) return redirect()->route('reception.login');
        $guest->delete();
        return redirect()->route('reception.index', ['tab' => 'guests'])->with('success', "Misafir kaydı silindi.");
    }

    public function storeCategory(Request $request)
    {
        if (!Auth::check()) return redirect()->route('reception.login');

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Category::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']) . '-' . rand(10, 99),
            'description' => $validated['description'],
            'is_active' => true,
            'sort_order' => (int)Category::max('sort_order') + 1,
        ]);

        return redirect()->route('reception.index', ['tab' => 'categories'])->with('success', "Kategori '{$validated['name']}' başarıyla oluşturuldu.");
    }

    public function updateCategory(Request $request, Category $category)
    {
        if (!Auth::check()) return redirect()->route('reception.login');

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer',
        ]);

        $category->update($validated);

        return redirect()->route('reception.index', ['tab' => 'categories'])->with('success', "Kategori '{$category->name}' güncellendi.");
    }

    public function toggleCategory(Category $category)
    {
        if (!Auth::check()) return redirect()->route('reception.login');
        $category->update(['is_active' => !$category->is_active]);
        return redirect()->route('reception.index', ['tab' => 'categories'])->with('success', "{$category->name} durumu güncellendi.");
    }

    public function deleteCategory(Category $category)
    {
        if (!Auth::check()) return redirect()->route('reception.login');
        $category->delete();
        return redirect()->route('reception.index', ['tab' => 'categories'])->with('success', "Kategori silindi.");
    }

    public function reorderCategory(Request $request, Category $category)
    {
        if (!Auth::check()) return redirect()->route('reception.login');

        $direction = $request->input('direction');
        $allCategories = Category::orderBy('sort_order')->orderBy('id')->get();
        
        foreach ($allCategories as $index => $cat) {
            if ($cat->sort_order !== ($index + 1)) {
                $cat->update(['sort_order' => $index + 1]);
            }
        }
        
        $category->refresh();
        $currentOrder = $category->sort_order;

        if ($direction === 'up') {
            $prev = Category::where('sort_order', '<', $currentOrder)->orderBy('sort_order', 'desc')->first();
            if ($prev) {
                $category->update(['sort_order' => $prev->sort_order]);
                $prev->update(['sort_order' => $currentOrder]);
            }
        } elseif ($direction === 'down') {
            $next = Category::where('sort_order', '>', $currentOrder)->orderBy('sort_order', 'asc')->first();
            if ($next) {
                $category->update(['sort_order' => $next->sort_order]);
                $next->update(['sort_order' => $currentOrder]);
            }
        }

        return redirect()->route('reception.index', ['tab' => 'categories'])->with('success', "{$category->name} kategorisinin sıralaması güncellendi.");
    }

    public function storeProduct(Request $request)
    {
        if (!Auth::check()) return redirect()->route('reception.login');

        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'sub_title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'taste_notes' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'badge' => 'nullable|string|max:50',
            'alcohol_percentage' => 'nullable|numeric|min:0|max:100',
            'volume_ml' => 'nullable|integer|min:0',
            'is_special' => 'nullable|boolean',
            'is_featured' => 'nullable|boolean',
        ]);

        Product::create([
            'category_id' => $validated['category_id'],
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']) . '-' . rand(100, 999),
            'sub_title' => $validated['sub_title'] ?? null,
            'description' => $validated['description'] ?? null,
            'taste_notes' => $validated['taste_notes'] ?? null,
            'price' => $validated['price'],
            'original_price' => $validated['original_price'] ?? null,
            'currency' => '₺',
            'badge' => $validated['badge'] ?? null,
            'alcohol_percentage' => $validated['alcohol_percentage'] ?? 0,
            'volume_ml' => $validated['volume_ml'] ?? null,
            'is_featured' => $request->boolean('is_special') || $request->boolean('is_featured'),
            'is_available' => true,
            'sort_order' => (int)Product::where('category_id', $validated['category_id'])->max('sort_order') + 1,
        ]);

        return redirect()->route('reception.index', ['tab' => 'products'])->with('success', "Ürün '{$validated['name']}' başarıyla eklendi.");
    }

    public function updateProduct(Request $request, Product $product)
    {
        if (!Auth::check()) return redirect()->route('reception.login');

        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'badge' => 'nullable|string|max:50',
            'taste_notes' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer',
        ]);

        $product->update([
            'category_id' => $validated['category_id'],
            'name' => $validated['name'],
            'price' => $validated['price'],
            'original_price' => $validated['original_price'] ?? null,
            'badge' => $validated['badge'] ?? null,
            'taste_notes' => $validated['taste_notes'] ?? null,
            'description' => $validated['description'] ?? null,
            'is_featured' => $request->boolean('is_special') || $request->boolean('is_featured'),
            'sort_order' => $validated['sort_order'] ?? $product->sort_order,
        ]);

        return redirect()->route('reception.index', ['tab' => 'products'])->with('success', "{$product->name} güncellendi.");
    }

    public function toggleProduct(Product $product)
    {
        if (!Auth::check()) return redirect()->route('reception.login');
        $product->update(['is_available' => !$product->is_available]);
        return redirect()->route('reception.index', ['tab' => 'products'])->with('success', "{$product->name} durumu güncellendi.");
    }

    public function deleteProduct(Product $product)
    {
        if (!Auth::check()) return redirect()->route('reception.login');
        $product->delete();
        return redirect()->route('reception.index', ['tab' => 'products'])->with('success', "Ürün silindi.");
    }

    public function reorderProduct(Request $request, Product $product)
    {
        if (!Auth::check()) return redirect()->route('reception.login');

        $direction = $request->input('direction');
        $categoryId = $product->category_id;
        
        $allProducts = Product::where('category_id', $categoryId)->orderBy('sort_order')->orderBy('id')->get();
        foreach ($allProducts as $index => $prod) {
            if ($prod->sort_order !== ($index + 1)) {
                $prod->update(['sort_order' => $index + 1]);
            }
        }
        
        $product->refresh();
        $currentOrder = $product->sort_order;

        if ($direction === 'up') {
            $prev = Product::where('category_id', $categoryId)
                ->where('sort_order', '<', $currentOrder)
                ->orderBy('sort_order', 'desc')
                ->first();
            if ($prev) {
                $product->update(['sort_order' => $prev->sort_order]);
                $prev->update(['sort_order' => $currentOrder]);
            }
        } elseif ($direction === 'down') {
            $next = Product::where('category_id', $categoryId)
                ->where('sort_order', '>', $currentOrder)
                ->orderBy('sort_order', 'asc')
                ->first();
            if ($next) {
                $product->update(['sort_order' => $next->sort_order]);
                $next->update(['sort_order' => $currentOrder]);
            }
        }

        $tab = $request->input('tab', 'categories');
        return redirect()->route('reception.index', ['tab' => $tab])->with('success', "{$product->name} ürününün sıralaması güncellendi.");
    }

    public function storeTable(Request $request)
    {
        if (!Auth::check()) return redirect()->route('reception.login');

        $validated = $request->validate([
            'table_number' => 'required|string|max:50|unique:club_tables,table_number',
            'name' => 'required|string|max:255',
            'section' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1|max:50',
        ]);

        $duration = config('mikale.token_expiration_minutes', 240);
        $qrToken = 'qr-' . strtolower($validated['table_number']) . '-' . Str::random(12);

        ClubTable::create([
            'table_number' => strtoupper($validated['table_number']),
            'name' => $validated['name'],
            'section' => $validated['section'],
            'capacity' => $validated['capacity'],
            'qr_token' => $qrToken,
            'token_expires_at' => now()->addMinutes($duration),
            'is_active' => true,
        ]);

        return redirect()->route('reception.index', ['tab' => 'tables'])->with('success', "Masa {$validated['table_number']} ve zaman ayarlı QR kodu başarıyla üretildi.");
    }

    public function updateTable(Request $request, ClubTable $table)
    {
        if (!Auth::check()) return redirect()->route('reception.login');

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'section' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1|max:50',
        ]);

        $table->update($validated);

        return redirect()->route('reception.index', ['tab' => 'tables'])->with('success', "Masa {$table->table_number} güncellendi.");
    }

    public function toggleTable(ClubTable $table)
    {
        if (!Auth::check()) return redirect()->route('reception.login');
        
        $newActive = !$table->is_active;
        if (!$newActive) {
            $table->expireToken();
            $table->update(['is_active' => false]);
        } else {
            $table->generateTimedToken();
        }

        return redirect()->route('reception.index', ['tab' => 'tables'])->with('success', "{$table->table_number} durumu güncellendi.");
    }

    public function deleteTable(ClubTable $table)
    {
        if (!Auth::check()) return redirect()->route('reception.login');
        $table->delete();
        return redirect()->route('reception.index', ['tab' => 'tables'])->with('success', "Masa silindi.");
    }

    public function regenerateTableQr(ClubTable $table)
    {
        if (!Auth::check()) return redirect()->route('reception.login');

        $table->generateTimedToken();

        return redirect()->route('reception.index', ['tab' => 'tables'])->with('success', "{$table->table_number} masasının süreli QR kodu yenilendi.");
    }

    public function printTableQr(ClubTable $table)
    {
        if (!Auth::check()) return redirect()->route('reception.login');
        return view('reception.print_table', compact('table'));
    }

    public function printAllTablesQr()
    {
        if (!Auth::check()) return redirect()->route('reception.login');
        $tables = ClubTable::where('is_active', true)->orderBy('table_number')->get();
        return view('reception.print_all', compact('tables'));
    }

    public function checkout(Request $request, ClubGuest $guest)
    {
        if (!Auth::check()) return redirect()->route('reception.login');

        $totalSpent = $guest->totalSpent();

        Bill::create([
            'bill_number' => 'INV-' . date('Ymd') . '-' . strtoupper(Str::random(4)),
            'club_guest_id' => $guest->id,
            'club_table_id' => $guest->club_table_id,
            'subtotal' => $totalSpent,
            'service_fee' => $totalSpent * 0.10,
            'discount' => 0,
            'total_amount' => $totalSpent * 1.10,
            'payment_method' => $request->input('payment_method', 'credit_card'),
            'status' => 'paid',
            'paid_at' => now(),
        ]);

        $table = $guest->table;

        $guest->update([
            'status' => 'checked_out',
            'check_out_at' => now(),
        ]);

        if ($table) {
            $hasOtherActiveGuests = ClubGuest::where('club_table_id', $table->id)
                ->where('status', 'active')
                ->exists();
            if (!$hasOtherActiveGuests) {
                $table->generateTimedToken();
            }
        }

        return redirect()->route('reception.index', ['tab' => 'guests'])->with('success', "{$guest->name} hesabı kapatıldı ve masa oturumu yenilendi.");
    }

    public function updateOrderStatus(Request $request, Order $order)
    {
        if (!Auth::check()) return redirect()->route('reception.login');

        $validated = $request->validate([
            'status' => 'required|in:pending,preparing,served,completed,cancelled'
        ]);

        $order->update(['status' => $validated['status']]);

        return redirect()->route('reception.index', ['tab' => 'orders'])->with('success', "Sipariş #{$order->order_number} durumu '{$validated['status']}' olarak güncellendi.");
    }

    public function deleteOrder(Order $order)
    {
        if (!Auth::check()) return redirect()->route('reception.login');
        $order->delete();
        return redirect()->route('reception.index', ['tab' => 'orders'])->with('success', "Sipariş silindi.");
    }

    public function getLiveNotifications(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['success' => false], 401);
        }

        $sinceId = (int)$request->query('since_id', 0);

        $calls = WaiterCall::with(['table', 'guest', 'order.items.product'])
            ->latest()
            ->take(40)
            ->get()
            ->map(function ($call) {
                return [
                    'id' => $call->id,
                    'type' => $call->type,
                    'title' => $call->title,
                    'message' => $call->message,
                    'table_number' => $call->table_number,
                    'guest_name' => $call->guest_name,
                    'guest_code' => $call->guest_code,
                    'total_amount' => $call->total_amount ? number_format($call->total_amount, 0, ',', '.') . ' ₺' : null,
                    'order_items' => $call->order_items,
                    'status' => $call->status,
                    'time_ago' => $call->created_at ? $call->created_at->diffForHumans() : '',
                    'created_at_fmt' => $call->created_at ? $call->created_at->format('H:i:s') : '',
                ];
            });

        $pendingCount = WaiterCall::where('status', 'pending')->count();
        $newCallsCount = $sinceId > 0 ? WaiterCall::where('id', '>', $sinceId)->where('status', 'pending')->count() : 0;

        return response()->json([
            'success' => true,
            'pending_count' => $pendingCount,
            'new_count' => $newCallsCount,
            'latest_id' => $calls->first() ? $calls->first()['id'] : 0,
            'notifications' => $calls,
        ]);
    }

    public function updateWaiterCallStatus(Request $request, WaiterCall $call)
    {
        if (!Auth::check()) return response()->json(['success' => false], 401);

        $status = $request->input('status', 'completed');
        $call->update([
            'status' => $status,
            'responded_at' => now(),
        ]);

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'status' => $status]);
        }

        return back()->with('success', 'Bildirim durumu güncellendi.');
    }

    public function deleteWaiterCall(WaiterCall $call)
    {
        if (!Auth::check()) return response()->json(['success' => false], 401);

        $call->delete();

        return back()->with('success', 'Bildirim silindi.');
    }

    public function clearAllWaiterCalls()
    {
        if (!Auth::check()) return response()->json(['success' => false], 401);

        WaiterCall::where('status', 'pending')->update([
            'status' => 'completed',
            'responded_at' => now(),
        ]);

        return back()->with('success', 'Tüm bekleyen bildirimler tamamlandı olarak işaretlendi.');
    }

    public function updateSettings(Request $request)
    {
        if (!Auth::check()) return redirect()->route('reception.login');

        $user = Auth::user();

        $validated = $request->validate([
            'email' => 'required|email|unique:users,email,' . $user->id,
            'name' => 'nullable|string|max:255',
            'current_password' => 'nullable|string',
            'password' => 'nullable|string|min:4|confirmed',
        ]);

        if (!empty($validated['password'])) {
            if (!empty($validated['current_password']) && !Hash::check($validated['current_password'], $user->password)) {
                return redirect()->route('reception.index', ['tab' => 'settings'])->with('error', 'Mevcut şifreniz hatalı.');
            }
            $user->password = Hash::make($validated['password']);
        }

        $user->email = $validated['email'];
        if (!empty($validated['name'])) {
            $user->name = $validated['name'];
        }
        $user->save();

        return redirect()->route('reception.index', ['tab' => 'settings'])->with('success', 'Hesap ve giriş bilgileri başarıyla güncellendi.');
    }
}
