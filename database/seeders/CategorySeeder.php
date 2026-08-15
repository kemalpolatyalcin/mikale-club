<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'VIP Şampanya & Şişe Servisi',
                'slug' => 'vip-sampanya-sise-servisi',
                'icon_type' => 'champagne',
                'description' => 'Prestige Cuvée, vintage şampanyalar ve VIP masa şişe ritüelleri',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'İmza Kokteyller & Miksoloji',
                'slug' => 'imza-kokteyller-miksoloji',
                'icon_type' => 'cocktail',
                'description' => 'Usta miksolojistler tarafından hazırlanan artisan tütsülü ve altın dokunuşlu kokteyller',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Single Malt & Nadir Viskiler',
                'slug' => 'single-malt-nadir-viskiler',
                'icon_type' => 'whisky',
                'description' => 'İskoç, Japon ve Amerikan damıtımevlerinden yıllanmış ve seçkin viskiler',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Ultra-Premium İçkiler',
                'slug' => 'ultra-premium-ickiler',
                'icon_type' => 'spirit',
                'description' => 'Seçkin tekilalar, el yapımı cinler, rezerv votkalar ve yıllanmış konyaklar',
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'name' => 'Shot Tepsileri & Bomb Setleri',
                'slug' => 'shot-tepsileri-bomb-setleri',
                'icon_type' => 'shots',
                'description' => 'Masa enerjisini yükselten alevli shotlar, özel tepsiler ve parti ritüelleri',
                'sort_order' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'Lüks Şaraplar & Köpüklüler',
                'slug' => 'luks-saraplar-kopukluler',
                'icon_type' => 'wine',
                'description' => 'Bordeaux Grand Cru, Toskana ve seçkin dünya bağlarından seçkiler',
                'sort_order' => 6,
                'is_active' => true,
            ],
            [
                'name' => 'Artisan VIP Nargile',
                'slug' => 'artisan-vip-nargile',
                'icon_type' => 'hookah',
                'description' => 'Koyu yaprak Rus tütünleri, taze meyve lüleleri ve özel kristal takımlar',
                'sort_order' => 7,
                'is_active' => true,
            ],
            [
                'name' => 'VIP Lounge Atıştırmalıkları',
                'slug' => 'vip-lounge-atistirmaliklari',
                'icon_type' => 'food',
                'description' => 'Havyar, Wagyu slider, trüflü lezzetler ve gece tapasları',
                'sort_order' => 8,
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(['slug' => $category['slug']], $category);
        }
    }
}
