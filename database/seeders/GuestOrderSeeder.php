<?php

namespace Database\Seeders;

use App\Models\ClubGuest;
use App\Models\ClubTable;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Database\Seeder;

class GuestOrderSeeder extends Seeder
{
    public function run(): void
    {
        ClubGuest::query()->delete();
        Order::query()->delete();
        OrderItem::query()->delete();

        $table1 = ClubTable::where('table_number', 'VIP-01')->first();
        $table2 = ClubTable::where('table_number', 'VIP-02')->first();
        $table3 = ClubTable::where('table_number', 'T-01')->first();

        $guest1 = ClubGuest::create([
            'guest_code' => 'VIP-1001',
            'name' => 'Kemal Polat Yalçın',
            'phone' => '0532 100 00 01',
            'club_table_id' => $table1 ? $table1->id : null,
            'status' => 'active',
            'check_in_at' => now()->subHours(2),
        ]);

        $guest2 = ClubGuest::create([
            'guest_code' => 'VIP-1002',
            'name' => 'Kemal Polat',
            'phone' => '0533 200 00 02',
            'club_table_id' => $table1 ? $table1->id : null,
            'status' => 'active',
            'check_in_at' => now()->subMinutes(90),
        ]);

        $guest3 = ClubGuest::create([
            'guest_code' => 'VIP-1003',
            'name' => 'Yalçın Polat',
            'phone' => '0534 300 00 03',
            'club_table_id' => $table2 ? $table2->id : null,
            'status' => 'active',
            'check_in_at' => now()->subMinutes(50),
        ]);

        $p1 = Product::where('slug', 'midnight-obsidian-smoke')->first();
        $p2 = Product::where('slug', 'armand-de-brignac-ace-of-spades-gold')->first();
        $p3 = Product::where('slug', 'wagyu-beef-sliders-trio-3-adet')->first();

        if ($p1 && $p2 && $table1) {
            $order1 = Order::create([
                'order_number' => 'ORD-88214',
                'club_table_id' => $table1->id,
                'club_guest_id' => $guest1->id,
                'status' => 'preparing',
                'total_amount' => $p1->price * 2 + $p2->price,
                'guest_note' => 'Şampanya buz kovasında ateş şovu ile gelsin lütfen.',
            ]);

            OrderItem::create([
                'order_id' => $order1->id,
                'product_id' => $p1->id,
                'quantity' => 2,
                'unit_price' => $p1->price,
                'total_price' => $p1->price * 2,
                'special_instructions' => 'Biberiye ekstra tütsülensin',
                'status' => 'preparing',
            ]);

            OrderItem::create([
                'order_id' => $order1->id,
                'product_id' => $p2->id,
                'quantity' => 1,
                'unit_price' => $p2->price,
                'total_price' => $p2->price,
                'special_instructions' => 'Altın kadehler ile',
                'status' => 'preparing',
            ]);
        }

        if ($p3 && $table1) {
            $order2 = Order::create([
                'order_number' => 'ORD-88215',
                'club_table_id' => $table1->id,
                'club_guest_id' => $guest2->id,
                'status' => 'served',
                'total_amount' => $p3->price,
                'guest_note' => 'Trüf mayonez ayrı kapta',
            ]);

            OrderItem::create([
                'order_id' => $order2->id,
                'product_id' => $p3->id,
                'quantity' => 1,
                'unit_price' => $p3->price,
                'total_price' => $p3->price,
                'status' => 'served',
            ]);
        }
    }
}
