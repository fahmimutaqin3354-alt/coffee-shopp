<?php

namespace Database\Seeders;

use App\Models\CoffeeQuestion;
use App\Models\CoffeeRule;
use App\Models\CoffeeRuleCondition;
use App\Models\Menu;
use App\Models\User;
use Illuminate\Database\Seeder;

class CoffeeExpertSystemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Ensure admin and existing manager users have role 'admin'
        User::where('email', 'admin@gmail.com')
            ->orWhere('email', 'atmin@gmail.com')
            ->orWhere('email', 'like', '%admin%')
            ->orWhere('email', 'like', '%atmin%')
            ->orWhere('name', 'like', '%atmin%')
            ->orWhereIn('id', [1, 2, 3, 5])
            ->update(['role' => 'admin']);

        // 2. Ensure Espresso menu item exists in database
        $espressoMenu = Menu::where('nama_kopi', 'like', '%Espresso%')
            ->where('nama_kopi', 'not like', '%Matcha%')
            ->first();

        if (!$espressoMenu) {
            $espressoMenu = Menu::create([
                'nama_kopi' => 'Espresso',
                'harga' => 18000,
                'deskripsi' => 'Ekstrak kopi murni yang pekat, tebal, dengan crema keemasan dan rasa yang intens.',
                'gambar' => '1781423808.jpg',
                'kategori' => 'Espresso',
                'jenis_menu' => 'Coffee',
                'is_active' => true,
            ]);
        }

        // 2b. Ensure foundational target menus exist idempotently
        $americanoMenu = Menu::firstOrCreate(
            ['nama_kopi' => 'Americano'],
            [
                'harga' => 18000,
                'deskripsi' => 'Espresso yang dicampur air panas sehingga lebih ringan dan segar.',
                'gambar' => '1781423808.jpg',
                'kategori' => 'Espresso',
                'jenis_menu' => 'Coffee',
                'is_active' => true,
            ]
        );

        $latteMenu = Menu::firstOrCreate(
            ['nama_kopi' => 'Latte'],
            [
                'harga' => 24000,
                'deskripsi' => 'Espresso dengan susu steamed lembut dan foam tipis yang creamy.',
                'gambar' => '1780897260.jpg',
                'kategori' => 'Latte',
                'jenis_menu' => 'Coffee',
                'is_active' => true,
            ]
        );

        $vanillaLatteMenu = Menu::firstOrCreate(
            ['nama_kopi' => 'Vanilla Latte'],
            [
                'harga' => 25000,
                'deskripsi' => 'Latte creamy dengan sentuhan manis dan aroma vanilla yang lembut.',
                'gambar' => '1781424215.jpg',
                'kategori' => 'Latte',
                'jenis_menu' => 'Coffee',
                'is_active' => true,
            ]
        );

        $cappuccinoMenu = Menu::where('nama_kopi', 'like', '%Capuccino%')
            ->orWhere('nama_kopi', 'like', '%Cappuccino%')
            ->first();
        if (!$cappuccinoMenu) {
            $cappuccinoMenu = Menu::create([
                'nama_kopi' => 'Capuccino',
                'harga' => 22000,
                'deskripsi' => 'Perpaduan seimbang espresso, susu steamed, dan foam susu tebal.',
                'gambar' => '1781246696.jpg',
                'kategori' => 'Capucchino',
                'jenis_menu' => 'Coffee',
                'is_active' => true,
            ]);
        }

        $kopiGulaArenMenu = Menu::firstOrCreate(
            ['nama_kopi' => 'Kopi Gula Aren'],
            [
                'harga' => 19000,
                'deskripsi' => 'Espresso dengan susu segar dan pemanis gula aren khas nusantara.',
                'gambar' => '1781422928.jpg',
                'kategori' => 'Signature Coffee',
                'jenis_menu' => 'Coffee',
                'is_active' => true,
            ]
        );

        $mochaMenu = Menu::firstOrCreate(
            ['nama_kopi' => 'Mocha'],
            [
                'harga' => 24000,
                'deskripsi' => 'Campuran kaya antara espresso, susu, dan cokelat pekat istimewa.',
                'gambar' => '1781422786.jpg',
                'kategori' => 'Chocolate Coffee',
                'jenis_menu' => 'Coffee',
                'is_active' => true,
            ]
        );

        // 3. Questions
        $questions = [
            [
                'code' => 'P01',
                'question' => 'Seberapa kuat rasa kopi yang kamu sukai?',
                'input_type' => 'radio',
                'order' => 1,
                'is_active' => true,
                'options' => [
                    ['value' => 'rendah', 'label' => 'Rendah (Ringan & Lembut)'],
                    ['value' => 'sedang', 'label' => 'Sedang (Pas & Seimbang)'],
                    ['value' => 'tinggi', 'label' => 'Tinggi (Kuat & Pekat)'],
                ],
            ],
            [
                'code' => 'P02',
                'question' => 'Seberapa manis minuman yang kamu sukai?',
                'input_type' => 'radio',
                'order' => 2,
                'is_active' => true,
                'options' => [
                    ['value' => 'rendah', 'label' => 'Rendah (Sedikit / Pahit Alami)'],
                    ['value' => 'sedang', 'label' => 'Sedang (Manis Pas)'],
                    ['value' => 'tinggi', 'label' => 'Tinggi (Manis Legit)'],
                ],
            ],
            [
                'code' => 'P03',
                'question' => 'Apakah kamu menyukai susu atau tekstur creamy?',
                'input_type' => 'radio',
                'order' => 3,
                'is_active' => true,
                'options' => [
                    ['value' => 'ya', 'label' => 'Ya (Suka Susu / Creamy)'],
                    ['value' => 'tidak', 'label' => 'Tidak (Kopi Hitam / Murni)'],
                ],
            ],
            [
                'code' => 'P04',
                'question' => 'Apakah kamu menyukai rasa kopi yang pahit?',
                'input_type' => 'radio',
                'order' => 4,
                'is_active' => true,
                'options' => [
                    ['value' => 'ya', 'label' => 'Ya (Suka Pahit Alami Kopi)'],
                    ['value' => 'tidak', 'label' => 'Tidak (Lebih Suka Ramah di Lidah)'],
                ],
            ],
            [
                'code' => 'P05',
                'question' => 'Apakah kamu menyukai rasa espresso yang kuat dan dominan?',
                'input_type' => 'radio',
                'order' => 5,
                'is_active' => true,
                'options' => [
                    ['value' => 'ya', 'label' => 'Ya (Espresso Dominan)'],
                    ['value' => 'tidak', 'label' => 'Tidak (Espresso Halus / Ringan)'],
                ],
            ],
            [
                'code' => 'P06',
                'question' => 'Kamu lebih suka minuman yang disajikan bagaimana?',
                'input_type' => 'radio',
                'order' => 6,
                'is_active' => true,
                'options' => [
                    ['value' => 'panas', 'label' => 'Panas (Hot)'],
                    ['value' => 'dingin', 'label' => 'Dingin (Iced)'],
                    ['value' => 'tidak_masalah', 'label' => 'Tidak Masalah (Bebas)'],
                ],
            ],
        ];

        foreach ($questions as $qData) {
            CoffeeQuestion::updateOrCreate(
                ['code' => $qData['code']],
                $qData
            );
        }

        // 4. Initial Rules
        $rules = [
            [
                'code' => 'R01',
                'name' => 'R01 — Espresso Murni',
                'description' => 'Rekomendasi untuk pelanggan pencinta rasa kopi pekat, pahit, tanpa susu, dengan espresso dominan.',
                'target_menu_id' => $espressoMenu ? $espressoMenu->id : 1,
                'recommended_reason' => 'Espresso murni menyajikan ekstraksi kopi yang sangat kuat, pekat, intens, dan pahit mantap tanpa campuran susu. Sangat ideal bagi penikmat rasa kopi otentik.',
                'is_active' => true,
                'priority' => 10,
                'conditions' => [
                    ['question_code' => 'P01', 'operator' => '=', 'expected_value' => 'tinggi'],
                    ['question_code' => 'P04', 'operator' => '=', 'expected_value' => 'ya'],
                    ['question_code' => 'P05', 'operator' => '=', 'expected_value' => 'ya'],
                    ['question_code' => 'P03', 'operator' => '=', 'expected_value' => 'tidak'],
                ],
            ],
            [
                'code' => 'R02',
                'name' => 'R02 — Caffe Latte',
                'description' => 'Rekomendasi kopi bersusu lembut dengan rasa kopi ringan dan manis sedang.',
                'target_menu_id' => $latteMenu ? $latteMenu->id : 2,
                'recommended_reason' => 'Perpaduan espresso ringan dengan steamed milk lembut menghasilkan rasa creamy yang pas dan nyaman untuk selera manis sedang.',
                'is_active' => true,
                'priority' => 8,
                'conditions' => [
                    ['question_code' => 'P03', 'operator' => '=', 'expected_value' => 'ya'],
                    ['question_code' => 'P01', 'operator' => '=', 'expected_value' => 'rendah'],
                    ['question_code' => 'P02', 'operator' => '=', 'expected_value' => 'sedang'],
                ],
            ],
            [
                'code' => 'R03',
                'name' => 'R03 — Vanilla Latte Manis',
                'description' => 'Rekomendasi varian latte manis beraroma harum vanila untuk penyuka tekstur creamy lembut.',
                'target_menu_id' => $vanillaLatteMenu ? $vanillaLatteMenu->id : 2,
                'recommended_reason' => 'Varian latte dengan sentuhan manis sirup vanila lembut, sangat cocok untuk penikmat kopi yang menyukai rasa manis dan tekstur creamy.',
                'is_active' => true,
                'priority' => 8,
                'conditions' => [
                    ['question_code' => 'P03', 'operator' => '=', 'expected_value' => 'ya'],
                    ['question_code' => 'P01', 'operator' => '=', 'expected_value' => 'rendah'],
                    ['question_code' => 'P02', 'operator' => '=', 'expected_value' => 'tinggi'],
                ],
            ],
            [
                'code' => 'R04',
                'name' => 'R04 — Cappuccino',
                'description' => 'Rekomendasi perpaduan espresso mantap dengan foam susu tebal dan tekstur kaya.',
                'target_menu_id' => $cappuccinoMenu ? $cappuccinoMenu->id : 8,
                'recommended_reason' => 'Komposisi seimbang antara espresso yang berkarakter kuat sedang, susu hangat, dan lapisan foam tebal memberikan cita rasa kopi dominan bertekstur kaya.',
                'is_active' => true,
                'priority' => 9,
                'conditions' => [
                    ['question_code' => 'P03', 'operator' => '=', 'expected_value' => 'ya'],
                    ['question_code' => 'P01', 'operator' => '=', 'expected_value' => 'sedang'],
                    ['question_code' => 'P05', 'operator' => '=', 'expected_value' => 'ya'],
                ],
            ],
            [
                'code' => 'R05',
                'name' => 'R05 — Americano',
                'description' => 'Rekomendasi kopi hitam tanpa susu dengan kekuatan sedang yang bersih dan menyegarkan.',
                'target_menu_id' => $americanoMenu ? $americanoMenu->id : 1,
                'recommended_reason' => 'Americano dibuat dari espresso yang diencerkan dengan air, memberikan kopi hitam segar dengan karakter mantap tanpa rasa espresso yang terlalu pekat.',
                'is_active' => true,
                'priority' => 7,
                'conditions' => [
                    ['question_code' => 'P03', 'operator' => '=', 'expected_value' => 'tidak'],
                    ['question_code' => 'P01', 'operator' => '=', 'expected_value' => 'sedang'],
                    ['question_code' => 'P05', 'operator' => '=', 'expected_value' => 'tidak'],
                ],
            ],
        ];

        if ($kopiGulaArenMenu) {
            $rules[] = [
                'code' => 'R06',
                'name' => 'R06 — Kopi Gula Aren Dingin',
                'description' => 'Rekomendasi es kopi susu khas dengan manis legit gula aren disajikan dingin.',
                'target_menu_id' => $kopiGulaArenMenu->id,
                'recommended_reason' => 'Pilihan es kopi susu gula aren yang sangat segar disajikan dingin dengan perpaduan manis gurih khas Indonesia.',
                'is_active' => true,
                'priority' => 6,
                'conditions' => [
                    ['question_code' => 'P06', 'operator' => '=', 'expected_value' => 'dingin'],
                    ['question_code' => 'P03', 'operator' => '=', 'expected_value' => 'ya'],
                    ['question_code' => 'P02', 'operator' => '=', 'expected_value' => 'tinggi'],
                ],
            ];
        }

        if ($mochaMenu) {
            $rules[] = [
                'code' => 'R07',
                'name' => 'R07 — Caffe Mocha Hangat',
                'description' => 'Rekomendasi kopi hangat dengan paduan cokelat pekat dan susu lembut.',
                'target_menu_id' => $mochaMenu->id,
                'recommended_reason' => 'Minuman perpaduan espresso, susu, dan cokelat pekat yang memberikan rasa hangat dan kenyamanan ekstra saat dinikmati panas.',
                'is_active' => true,
                'priority' => 6,
                'conditions' => [
                    ['question_code' => 'P06', 'operator' => '=', 'expected_value' => 'panas'],
                    ['question_code' => 'P03', 'operator' => '=', 'expected_value' => 'ya'],
                    ['question_code' => 'P01', 'operator' => '=', 'expected_value' => 'sedang'],
                ],
            ];
        }

        foreach ($rules as $rData) {
            $conditions = $rData['conditions'];
            unset($rData['conditions']);

            $rule = CoffeeRule::updateOrCreate(
                ['code' => $rData['code']],
                $rData
            );

            // Synchronize conditions idempotently
            CoffeeRuleCondition::where('rule_id', $rule->id)->delete();
            foreach ($conditions as $cond) {
                CoffeeRuleCondition::create([
                    'rule_id' => $rule->id,
                    'question_code' => $cond['question_code'],
                    'operator' => $cond['operator'] ?? '=',
                    'expected_value' => $cond['expected_value'],
                    'condition_group' => $cond['condition_group'] ?? 'AND',
                ]);
            }
        }
    }
}
