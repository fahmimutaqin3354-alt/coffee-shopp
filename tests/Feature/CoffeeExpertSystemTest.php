<?php

namespace Tests\Feature;

use App\Models\CoffeeQuestion;
use App\Models\CoffeeRule;
use App\Models\CoffeeRuleCondition;
use App\Models\Menu;
use App\Models\User;
use App\Services\CoffeeRecommendationService;
use Database\Seeders\CoffeeExpertSystemSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CoffeeExpertSystemTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Seed initial expert system data
        $this->seed(CoffeeExpertSystemSeeder::class);
    }

    /**
     * 1. Preferensi kopi kuat, pahit, tanpa susu, dan menyukai espresso menghasilkan Espresso.
     */
    public function test_forward_chaining_recommends_espresso_for_strong_bitter_no_milk_espresso_preference(): void
    {
        $service = new CoffeeRecommendationService();
        $answers = [
            'P01' => 'tinggi',
            'P02' => 'rendah',
            'P03' => 'tidak',
            'P04' => 'ya',
            'P05' => 'ya',
            'P06' => 'panas',
        ];

        $result = $service->infer($answers);

        $this->assertTrue($result['has_matches']);
        $recommendedMenuNames = collect($result['recommendations'])->pluck('menu.nama_kopi')->toArray();
        $this->assertContains('Espresso', $recommendedMenuNames);
    }

    /**
     * 2. Preferensi kopi ringan, creamy, dan manis sedang menghasilkan Latte jika rule sesuai.
     */
    public function test_forward_chaining_recommends_latte_for_mild_creamy_medium_sweet_preference(): void
    {
        $service = new CoffeeRecommendationService();
        $answers = [
            'P01' => 'rendah',
            'P02' => 'sedang',
            'P03' => 'ya',
            'P04' => 'tidak',
            'P05' => 'tidak',
            'P06' => 'panas',
        ];

        $result = $service->infer($answers);

        $this->assertTrue($result['has_matches']);
        $recommendedMenuNames = collect($result['recommendations'])->pluck('menu.nama_kopi')->toArray();
        $this->assertContains('Latte', $recommendedMenuNames);
    }

    /**
     * 3. Preferensi creamy dengan kekuatan kopi sedang dan menyukai espresso menghasilkan Cappuccino jika rule sesuai.
     */
    public function test_forward_chaining_recommends_cappuccino_for_creamy_medium_strength_espresso_preference(): void
    {
        $service = new CoffeeRecommendationService();
        $answers = [
            'P01' => 'sedang',
            'P02' => 'rendah',
            'P03' => 'ya',
            'P04' => 'ya',
            'P05' => 'ya',
            'P06' => 'panas',
        ];

        $result = $service->infer($answers);

        $this->assertTrue($result['has_matches']);
        $recommendedMenuNames = collect($result['recommendations'])->pluck('menu.nama_kopi')->toArray();
        
        $hasCappuccino = collect($recommendedMenuNames)->contains(function ($name) {
            return str_contains(strtolower($name), 'capuc') || str_contains(strtolower($name), 'cappuc');
        });
        $this->assertTrue($hasCappuccino, 'Should recommend Capuccino / Cappuccino');
    }

    /**
     * 4. Pilihan suhu dingin mengarahkan hasil ke varian dingin yang tersedia.
     */
    public function test_cold_temperature_preference_handles_cold_recommendation(): void
    {
        $service = new CoffeeRecommendationService();
        $answers = [
            'P01' => 'rendah',
            'P02' => 'tinggi',
            'P03' => 'ya',
            'P04' => 'tidak',
            'P05' => 'tidak',
            'P06' => 'dingin',
        ];

        $result = $service->infer($answers);

        $this->assertTrue($result['has_matches']);
        $rec = $result['recommendations'][0];
        $this->assertEquals('Disajikan Dingin (Es)', $rec['serving_suggestion']);
    }

    /**
     * 5. Tidak ada rule yang cocok menghasilkan empty state.
     */
    public function test_empty_state_when_no_rules_match(): void
    {
        // Deactivate all rules
        CoffeeRule::query()->update(['is_active' => false]);

        $service = new CoffeeRecommendationService();
        $answers = [
            'P01' => 'tinggi',
            'P02' => 'tinggi',
            'P03' => 'tidak',
            'P04' => 'tidak',
            'P05' => 'tidak',
            'P06' => 'tidak_masalah',
        ];

        $result = $service->infer($answers);

        $this->assertFalse($result['has_matches']);
        $this->assertEmpty($result['recommendations']);
        $this->assertCount(0, $result['fired_rules']);
    }

    /**
     * 6. Dua rule yang cocok tidak menghasilkan kartu menu duplikat.
     */
    public function test_multiple_matching_rules_do_not_produce_duplicate_menu_items(): void
    {
        $latteMenu = Menu::where('nama_kopi', 'like', '%Latte%')->first();

        // Create two overlapping rules pointing to the exact same menu
        $ruleA = CoffeeRule::create([
            'code' => 'TEST_R1',
            'name' => 'Test Rule A',
            'target_menu_id' => $latteMenu->id,
            'recommended_reason' => 'Alasan A',
            'is_active' => true,
            'priority' => 10,
        ]);
        CoffeeRuleCondition::create([
            'rule_id' => $ruleA->id,
            'question_code' => 'P03',
            'operator' => '=',
            'expected_value' => 'ya',
        ]);

        $ruleB = CoffeeRule::create([
            'code' => 'TEST_R2',
            'name' => 'Test Rule B',
            'target_menu_id' => $latteMenu->id,
            'recommended_reason' => 'Alasan B',
            'is_active' => true,
            'priority' => 5,
        ]);
        CoffeeRuleCondition::create([
            'rule_id' => $ruleB->id,
            'question_code' => 'P03',
            'operator' => '=',
            'expected_value' => 'ya',
        ]);

        $service = new CoffeeRecommendationService();
        $answers = [
            'P01' => 'rendah',
            'P02' => 'rendah',
            'P03' => 'ya',
            'P04' => 'tidak',
            'P05' => 'tidak',
            'P06' => 'panas',
        ];

        $result = $service->infer($answers);

        $menuIds = collect($result['recommendations'])->pluck('menu.id')->toArray();
        $uniqueMenuIds = array_unique($menuIds);

        $this->assertEquals(count($uniqueMenuIds), count($menuIds), 'Recommendation cards must be deduplicated by menu ID');
    }

    /**
     * 7. Rule nonaktif tidak digunakan.
     */
    public function test_inactive_rules_are_not_evaluated(): void
    {
        $espressoRule = CoffeeRule::where('code', 'R01')->first();
        $espressoRule->update(['is_active' => false]);

        $service = new CoffeeRecommendationService();
        $answers = [
            'P01' => 'tinggi',
            'P02' => 'rendah',
            'P03' => 'tidak',
            'P04' => 'ya',
            'P05' => 'ya',
            'P06' => 'panas',
        ];

        $result = $service->infer($answers);

        $firedCodes = collect($result['fired_rules'])->pluck('code')->toArray();
        $this->assertNotContains('R01', $firedCodes);
    }

    /**
     * 8. Menu yang tidak aktif tidak direkomendasikan.
     */
    public function test_inactive_menus_are_not_recommended(): void
    {
        $espressoRule = CoffeeRule::where('code', 'R01')->first();
        $espressoMenu = $espressoRule->targetMenu;
        $espressoMenu->update(['is_active' => false]);

        $service = new CoffeeRecommendationService();
        $answers = [
            'P01' => 'tinggi',
            'P02' => 'rendah',
            'P03' => 'tidak',
            'P04' => 'ya',
            'P05' => 'ya',
            'P06' => 'panas',
        ];

        $result = $service->infer($answers);

        $recommendedMenuIds = collect($result['recommendations'])->pluck('menu.id')->toArray();
        $this->assertNotContains($espressoMenu->id, $recommendedMenuIds);
    }

    /**
     * 9. Jawaban yang tidak valid ditolak oleh validasi backend.
     */
    public function test_invalid_consultation_answers_are_rejected(): void
    {
        // Missing required questions
        $response = $this->post(route('rekomendasi.proses'), [
            'P01' => 'tinggi',
            // P02, P03, P04, P05, P06 missing
        ]);

        $response->assertSessionHasErrors(['P02', 'P03', 'P04', 'P05', 'P06']);

        // Invalid answer value
        $response2 = $this->post(route('rekomendasi.proses'), [
            'P01' => 'hacked_value_123',
            'P02' => 'rendah',
            'P03' => 'ya',
            'P04' => 'ya',
            'P05' => 'ya',
            'P06' => 'panas',
        ]);

        $response2->assertSessionHasErrors(['P01']);
    }

    /**
     * 10. Pengguna tanpa hak admin tidak bisa mengubah knowledge base.
     */
    public function test_non_admin_cannot_access_or_modify_knowledge_base(): void
    {
        // Unauthenticated guest
        $guestResponse = $this->get(route('admin.aturan.index'));
        $guestResponse->assertRedirect(route('login'));

        // Authenticated customer (non-admin)
        $customer = User::factory()->create([
            'role' => 'pelanggan',
            'email' => 'customer_test@example.com',
        ]);

        $customerResponse = $this->actingAs($customer)->get(route('admin.aturan.index'));
        $customerResponse->assertStatus(403);

        $customerPostResponse = $this->actingAs($customer)->post(route('admin.aturan.store'), [
            'code' => 'HACK01',
            'name' => 'Unauthorized Rule',
            'target_menu_id' => 1,
            'recommended_reason' => 'Test',
        ]);
        $customerPostResponse->assertStatus(403);

        // Authenticated admin can access
        $admin = User::factory()->create([
            'role' => 'admin',
            'email' => 'realadmin@example.com',
        ]);

        $adminResponse = $this->actingAs($admin)->get(route('admin.aturan.index'));
        $adminResponse->assertStatus(200);
    }

    /**
     * 11. Seeder dapat dijalankan berulang kali tanpa duplikasi.
     */
    public function test_seeder_is_idempotent(): void
    {
        $qCountBefore = CoffeeQuestion::count();
        $rCountBefore = CoffeeRule::count();
        $cCountBefore = CoffeeRuleCondition::count();

        // Run seeder second time
        $this->seed(CoffeeExpertSystemSeeder::class);

        $this->assertEquals($qCountBefore, CoffeeQuestion::count());
        $this->assertEquals($rCountBefore, CoffeeRule::count());
        $this->assertEquals($cCountBefore, CoffeeRuleCondition::count());
    }

    /**
     * 12. Fitur menu, stok, pelanggan, penjualan, dan pemesanan lama tetap berfungsi.
     */
    public function test_existing_public_and_admin_features_remain_functional(): void
    {
        // Landing page
        $this->get('/')->assertStatus(200);

        // Menu pelanggan
        $this->get('/menu-pelanggan')->assertStatus(200);

        // Recommendation landing & consultation
        $this->get('/rekomendasi')->assertStatus(200);
        $this->get('/rekomendasi/konsultasi')->assertStatus(200);

        // Cart index
        $this->get('/cart')->assertStatus(200);

        // Admin dashboard (when authenticated as admin)
        $admin = User::where('role', 'admin')->first() ?: User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin)->get('/dashboard')->assertStatus(200);
        $this->actingAs($admin)->get('/menu')->assertStatus(200);
        $this->actingAs($admin)->get('/pesanan')->assertStatus(200);
    }
}
