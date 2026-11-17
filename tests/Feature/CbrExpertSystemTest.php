<?php

namespace Tests\Feature;

use App\Models\CbrCase;
use App\Models\User;
use App\Services\CbrReasoningService;
use Database\Seeders\CbrCaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CbrExpertSystemTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(CbrCaseSeeder::class);
    }

    private function createAdmin(): User
    {
        return User::factory()->create([
            'role' => 'admin',
            'email' => 'admin_cbr_test@example.com',
            'name' => 'Admin CBR',
        ]);
    }

    private function createKaryawan(): User
    {
        return User::factory()->create([
            'role' => 'karyawan',
            'email' => 'karyawan_cbr_test@example.com',
            'name' => 'Karyawan CBR',
        ]);
    }

    /**
     * 1. Guest tidak bisa mengakses CBR dan dialihkan ke login.
     */
    public function test_guest_cannot_access_cbr(): void
    {
        $response = $this->get(route('admin.cbr.index'));
        $response->assertRedirect(route('login'));

        $response = $this->get(route('admin.cbr.konsultasi'));
        $response->assertRedirect(route('login'));
    }

    /**
     * 2. Karyawan (non-admin) ditolak saat mengakses CBR (403 Forbidden).
     */
    public function test_karyawan_cannot_access_cbr_admin_only(): void
    {
        $karyawan = $this->createKaryawan();

        $response = $this->actingAs($karyawan)->get(route('admin.cbr.index'));
        $response->assertStatus(403);

        $response = $this->actingAs($karyawan)->get(route('admin.cbr.konsultasi'));
        $response->assertStatus(403);
    }

    /**
     * 3. Admin dapat mengakses halaman Basis Kasus dan Konsultasi CBR.
     */
    public function test_admin_can_access_cbr_pages(): void
    {
        $admin = $this->createAdmin();

        $response = $this->actingAs($admin)->get(route('admin.cbr.index'));
        $response->assertStatus(200);
        $response->assertSee('Basis Kasus Operasional');
        $response->assertSee('CBR001');

        $response = $this->actingAs($admin)->get(route('admin.cbr.konsultasi'));
        $response->assertStatus(200);
        $response->assertSee('PENANGANAN MASALAH OPERASIONAL');
        $response->assertSee('RETRIEVE');
    }

    /**
     * 4. Kasus "Kopi terlalu pahit" mengembalikan rekomendasi CBR001 (Retrieve & Reuse).
     */
    public function test_cbr_retrieves_kopi_terlalu_pahit_solution(): void
    {
        $admin = $this->createAdmin();

        $response = $this->actingAs($admin)->post(route('admin.cbr.proses'), [
            'kategori_masalah' => 'Mesin Espresso',
            'gejala' => ['Rasa kopi sangat pahit', 'After taste tidak enak'],
            'kondisi' => ['Durasi ekstraksi terlalu lama', 'Suhu air terlalu tinggi'],
        ]);

        $response->assertStatus(200);
        $response->assertSee('Kopi terlalu pahit');
        $response->assertSee('CBR001');
        $response->assertSee('Periksa dan kurangi durasi ekstraksi');
    }

    /**
     * 5. Kasus "Kopi terlalu encer" mengembalikan rekomendasi CBR002.
     */
    public function test_cbr_retrieves_kopi_terlalu_encer_solution(): void
    {
        $admin = $this->createAdmin();

        $response = $this->actingAs($admin)->post(route('admin.cbr.proses'), [
            'kategori_masalah' => 'Mesin Espresso',
            'gejala' => ['Espresso terlihat encer', 'Crema tipis atau tidak ada'],
            'kondisi' => ['Dosis bubuk kopi kurang', 'Grind size terlalu kasar'],
        ]);

        $response->assertStatus(200);
        $response->assertSee('Kopi terlalu encer');
        $response->assertSee('CBR002');
        $response->assertSee('Periksa dosis bubuk kopi');
    }

    /**
     * 6. Kasus "Mesin tidak mengeluarkan air" mengembalikan rekomendasi CBR003.
     */
    public function test_cbr_retrieves_mesin_tidak_keluar_air_solution(): void
    {
        $admin = $this->createAdmin();

        $response = $this->actingAs($admin)->post(route('admin.cbr.proses'), [
            'kategori_masalah' => 'Mesin Espresso',
            'gejala' => ['Air tidak keluar dari group head', 'Suara pompa abnormal'],
            'kondisi' => ['Saluran air tersumbat'],
        ]);

        $response->assertStatus(200);
        $response->assertSee('Mesin tidak mengeluarkan air');
        $response->assertSee('CBR003');
        $response->assertSee('Periksa saluran air');
    }

    /**
     * 7. Admin dapat menyimpan kasus baru ke Case Base (Retain).
     */
    public function test_admin_can_retain_new_case(): void
    {
        $admin = $this->createAdmin();

        $response = $this->actingAs($admin)->post(route('admin.cbr.store'), [
            'judul_masalah' => 'Portafilter bocor dari samping',
            'kategori_masalah' => 'Mesin Espresso',
            'gejala' => ['Air dan bubuk merembes keluar dari pinggir portafilter', 'Tekanan bocor'],
            'kondisi' => ['Gasket group head sudah aus atau getas', 'Bubuk kopi menempel di bibir basket'],
            'solusi' => 'Bersihkan bibir basket portafilter. Jika masih bocor, ganti karet gasket group head baru.',
            'langkah_penanganan' => [
                'Lepaskan portafilter dan lap bibir basket',
                'Gunakan sikat group head untuk membersihkan alur shower screen',
                'Cek kondisi karet gasket apakah sudah keras',
                'Ganti gasket baru jika sudah berumur > 6 bulan'
            ],
            'bobot' => 1.0,
            'is_verified' => 1,
        ]);

        $response->assertRedirect(route('admin.cbr.index'));
        $this->assertDatabaseHas('cbr_cases', [
            'judul_masalah' => 'Portafilter bocor dari samping',
            'kategori_masalah' => 'Mesin Espresso',
        ]);
    }

    /**
     * 8. Admin dapat mengupdate kasus yang sudah ada (Revise).
     */
    public function test_admin_can_revise_case(): void
    {
        $admin = $this->createAdmin();
        $case = CbrCase::where('kode_kasus', 'CBR001')->firstOrFail();

        $response = $this->actingAs($admin)->put(route('admin.cbr.update', $case->id), [
            'judul_masalah' => 'Kopi terlalu pahit atau over-ekstraksi',
            'kategori_masalah' => 'Mesin Espresso',
            'gejala' => ['Rasa kopi sangat pahit dan sepat'],
            'kondisi' => ['Durasi ekstraksi > 35 detik'],
            'solusi' => 'Kurangi durasi ekstraksi ke 25-30 detik dan kalibrasi grinder.',
            'langkah_penanganan' => ['Putar grinder 1 klik lebih kasar'],
            'bobot' => 1.0,
            'is_verified' => 1,
        ]);

        $response->assertRedirect(route('admin.cbr.index'));
        $case->refresh();
        $this->assertEquals('Kopi terlalu pahit atau over-ekstraksi', $case->judul_masalah);
    }

    /**
     * 9. Admin dapat mengaktifkan / menonaktifkan kasus dan menghapus kasus.
     */
    public function test_admin_can_toggle_and_delete_case(): void
    {
        $admin = $this->createAdmin();
        $case = CbrCase::where('kode_kasus', 'CBR001')->firstOrFail();

        // Toggle
        $response = $this->actingAs($admin)->post(route('admin.cbr.toggle', $case->id));
        $response->assertStatus(302);
        $case->refresh();
        $this->assertFalse($case->is_active);

        // Delete
        $response = $this->actingAs($admin)->delete(route('admin.cbr.destroy', $case->id));
        $response->assertRedirect(route('admin.cbr.index'));
        $this->assertDatabaseMissing('cbr_cases', ['id' => $case->id]);
    }
}
