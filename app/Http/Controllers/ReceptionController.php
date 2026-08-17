<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\ClubGuest;
use App\Models\ClubTable;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ReceptionController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        $activeGuests = ClubGuest::with(['table', 'orders'])
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

        $recentCheckouts = ClubGuest::with('table')
            ->where('status', 'checked_out')
            ->latest('check_out_at')
            ->take(5)
            ->get();

        $tables = ClubTable::where('is_active', true)->orderBy('table_number')->get();

        $totalActiveSpent = $activeGuests->sum(function ($guest) {
            return $guest->totalSpent();
        });

        return view('reception.index', compact('activeGuests', 'recentCheckouts', 'tables', 'totalActiveSpent', 'search'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:50',
            'club_table_id' => 'nullable|exists:club_tables,id',
        ]);

        $code = 'VIP-' . strtoupper(Str::random(4));
        while (ClubGuest::where('guest_code', $code)->exists()) {
            $code = 'VIP-' . strtoupper(Str::random(4));
        }

        ClubGuest::create([
            'guest_code' => $code,
            'name' => $validated['name'],
            'phone' => $validated['phone'] ?? null,
            'club_table_id' => $validated['club_table_id'] ?? null,
            'status' => 'active',
            'check_in_at' => now(),
        ]);

        return redirect()->route('reception.index')->with('success', "Misafir {$validated['name']} ({$code}) başarıyla kaydedildi.");
    }

    public function checkout(Request $request, ClubGuest $guest)
    {
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

        $guest->update([
            'status' => 'checked_out',
            'check_out_at' => now(),
        ]);

        return redirect()->route('reception.index')->with('success', "{$guest->name} hesabı tahsil edildi ve oturumu kapatıldı.");
    }
}
