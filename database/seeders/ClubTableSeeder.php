<?php

namespace Database\Seeders;

use App\Models\ClubTable;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ClubTableSeeder extends Seeder
{
    public function run(): void
    {
        $tables = [
            ['table_number' => 'VIP-01', 'name' => 'Royal VIP Suite 1', 'section' => 'VIP Lounge', 'capacity' => 8],
            ['table_number' => 'VIP-02', 'name' => 'Royal VIP Suite 2', 'section' => 'VIP Lounge', 'capacity' => 8],
            ['table_number' => 'VIP-03', 'name' => 'Diamond VIP Table 3', 'section' => 'VIP Lounge', 'capacity' => 6],
            ['table_number' => 'VIP-04', 'name' => 'Diamond VIP Table 4', 'section' => 'VIP Lounge', 'capacity' => 6],
            ['table_number' => 'VIP-05', 'name' => 'Black Box VIP 5', 'section' => 'VIP Lounge', 'capacity' => 6],
            ['table_number' => 'VIP-06', 'name' => 'Black Box VIP 6', 'section' => 'VIP Lounge', 'capacity' => 6],

            ['table_number' => 'T-01', 'name' => 'Dancefloor High Table 1', 'section' => 'Main Floor', 'capacity' => 4],
            ['table_number' => 'T-02', 'name' => 'Dancefloor High Table 2', 'section' => 'Main Floor', 'capacity' => 4],
            ['table_number' => 'T-03', 'name' => 'Dancefloor High Table 3', 'section' => 'Main Floor', 'capacity' => 4],
            ['table_number' => 'T-04', 'name' => 'Dancefloor High Table 4', 'section' => 'Main Floor', 'capacity' => 4],
            ['table_number' => 'T-05', 'name' => 'DJ Front Table 5', 'section' => 'Main Floor', 'capacity' => 5],
            ['table_number' => 'T-06', 'name' => 'DJ Front Table 6', 'section' => 'Main Floor', 'capacity' => 5],
            ['table_number' => 'T-07', 'name' => 'Club Center Table 7', 'section' => 'Main Floor', 'capacity' => 4],
            ['table_number' => 'T-08', 'name' => 'Club Center Table 8', 'section' => 'Main Floor', 'capacity' => 4],

            ['table_number' => 'TR-01', 'name' => 'Sky Terrace Lounge 1', 'section' => 'Terrace & Rooftop', 'capacity' => 6],
            ['table_number' => 'TR-02', 'name' => 'Sky Terrace Lounge 2', 'section' => 'Terrace & Rooftop', 'capacity' => 6],
            ['table_number' => 'TR-03', 'name' => 'Terrace View Table 3', 'section' => 'Terrace & Rooftop', 'capacity' => 4],
            ['table_number' => 'TR-04', 'name' => 'Terrace View Table 4', 'section' => 'Terrace & Rooftop', 'capacity' => 4],
            ['table_number' => 'TR-05', 'name' => 'Garden Cabana 5', 'section' => 'Terrace & Rooftop', 'capacity' => 6],
            ['table_number' => 'TR-06', 'name' => 'Garden Cabana 6', 'section' => 'Terrace & Rooftop', 'capacity' => 6],

            ['table_number' => 'BAR-01', 'name' => 'Cocktail Bar Station 1', 'section' => 'Cocktail Bar', 'capacity' => 2],
            ['table_number' => 'BAR-02', 'name' => 'Cocktail Bar Station 2', 'section' => 'Cocktail Bar', 'capacity' => 2],
            ['table_number' => 'BAR-03', 'name' => 'Cocktail Bar Station 3', 'section' => 'Cocktail Bar', 'capacity' => 2],
            ['table_number' => 'BAR-04', 'name' => 'Cocktail Bar Station 4', 'section' => 'Cocktail Bar', 'capacity' => 2],
        ];

        foreach ($tables as $table) {
            ClubTable::updateOrCreate(
                ['table_number' => $table['table_number']],
                [
                    'name' => $table['name'],
                    'section' => $table['section'],
                    'capacity' => $table['capacity'],
                    'qr_token' => 'qr-' . strtolower($table['table_number']) . '-' . Str::random(8),
                    'is_active' => true,
                ]
            );
        }
    }
}
