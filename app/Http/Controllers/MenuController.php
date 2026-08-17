<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ClubTable;
use App\Models\Product;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $tableToken = $request->query('table');
        $activeTable = null;

        if ($tableToken) {
            $activeTable = ClubTable::where('qr_token', $tableToken)
                ->orWhere('table_number', $tableToken)
                ->first();
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

        return view('menu.index', compact('categories', 'dailySpecials', 'activeTable'));
    }
}
