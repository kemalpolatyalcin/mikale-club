<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ClubGuest;
use App\Models\ClubTable;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $tableToken = $request->query('table') ?? session('current_table_number');
        $activeTable = null;
        $tableGuests = collect([]);
        $tableOrders = collect([]);
        $currentGuest = null;

        if ($tableToken) {
            $activeTable = ClubTable::where('qr_token', $tableToken)
                ->orWhere('table_number', $tableToken)
                ->first();

            if ($activeTable) {
                session([
                    'current_table_id' => $activeTable->id,
                    'current_table_number' => $activeTable->table_number,
                ]);

                $tableGuests = ClubGuest::where('club_table_id', $activeTable->id)
                    ->where('status', 'active')
                    ->get();

                $tableOrders = Order::with(['guest', 'items.product'])
                    ->where('club_table_id', $activeTable->id)
                    ->latest()
                    ->take(10)
                    ->get();
            }
        }

        if (session('guest_id')) {
            $currentGuest = ClubGuest::where('id', session('guest_id'))
                ->where('status', 'active')
                ->first();

            if (!$currentGuest) {
                session()->forget(['guest_id', 'guest_code', 'guest_name']);
            }
        }

        $categories = Category::where('is_active', true)
            ->with(['activeProducts'])
            ->orderBy('sort_order')
            ->get();

        $dailySpecials = Product::where('is_available', true)
            ->whereIn('slug', ['midnight-obsidian-smoke', 'armand-de-brignac-ace-of-spades-gold'])
            ->get();

        if ($dailySpecials->count() < 2) {
            $dailySpecials = Product::where('is_available', true)
                ->where('is_featured', true)
                ->take(2)
                ->get();
        }

        return view('menu.index', compact('categories', 'dailySpecials', 'activeTable', 'currentGuest', 'tableGuests', 'tableOrders'));
    }
}
