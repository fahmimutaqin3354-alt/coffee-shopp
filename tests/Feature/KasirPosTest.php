<?php

namespace Tests\Feature;

use App\Models\Menu;
use App\Models\Penjualan;
use App\Models\Pesanan;
use App\Models\User;
use Database\Seeders\CoffeeExpertSystemSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KasirPosTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(CoffeeExpertSystemSeeder::class);
    }

    /**
     * Test karyawan can log in and access kasir POS interface.
     */
    public function test_karyawan_can_access_kasir_pos(): void
    {
        $karyawan = User::factory()->create([
            'role' => 'karyawan',
            'email' => 'kasir_test@example.com',
        ]);

        $response = $this->actingAs($karyawan)->get(route('kasir.index'));
        $response->assertStatus(200);
        $response->assertSee('KASIR POS');
    }

    /**
     * Test guest cannot access kasir POS and is redirected to login.
     */
    public function test_guest_cannot_access_kasir(): void
    {
        $response = $this->get(route('kasir.index'));
        $response->assertRedirect(route('login'));
    }

    /**
     * Test regular customer (role pelanggan) cannot access kasir POS (403).
     */
    public function test_pelanggan_cannot_access_kasir(): void
    {
        $pelanggan = User::factory()->create([
            'role' => 'pelanggan',
            'email' => 'customer_only@example.com',
        ]);

        $response = $this->actingAs($pelanggan)->get(route('kasir.index'));
        $response->assertStatus(403);
    }

    /**
     * Test karyawan cannot access admin knowledge base system (403).
     */
    public function test_karyawan_cannot_access_admin_expert_system(): void
    {
        $karyawan = User::factory()->create([
            'role' => 'karyawan',
            'email' => 'kasir_restricted@example.com',
        ]);

        $response = $this->actingAs($karyawan)->get(route('admin.aturan.index'));
        $response->assertStatus(403);
    }

    /**
     * Test kasir can process a POS transaction successfully.
     */
    public function test_kasir_can_store_pos_transaction(): void
    {
        $karyawan = User::factory()->create([
            'role' => 'karyawan',
            'name' => 'Budi Kasir',
        ]);

        $menu = Menu::where('nama_kopi', 'like', '%Latte%')->first();

        $response = $this->actingAs($karyawan)->post(route('kasir.store'), [
            'nama_pembeli' => 'John Doe',
            'nomor_meja' => 'Meja 5',
            'metode_pembayaran' => 'Cash',
            'status_pembayaran' => 'Sudah Dibayar',
            'uang_diterima' => 50000,
            'kembalian' => 50000 - ($menu->harga * 2),
            'items' => [
                [
                    'menu_id' => $menu->id,
                    'jumlah' => 2,
                ],
            ],
        ]);

        $response->assertRedirect(route('kasir.index'));
        $response->assertSessionHas('success_pesanan');

        // Verify Pesanan was created
        $this->assertDatabaseHas('pesanans', [
            'nama_pembeli' => 'John Doe',
            'nomor_meja' => 'Meja 5',
            'menu_id' => $menu->id,
            'jumlah' => 2,
            'status_pembayaran' => 'Sudah Dibayar',
            'kasir_nama' => 'Budi Kasir',
        ]);

        // Verify Penjualan was automatically recorded
        $this->assertDatabaseHas('penjualans', [
            'nama_pembeli' => 'John Doe',
            'nama_kopi' => $menu->nama_kopi,
            'jumlah' => 2,
        ]);
    }

    /**
     * Test kasir can print receipt.
     */
    public function test_kasir_can_view_receipt(): void
    {
        $karyawan = User::factory()->create(['role' => 'karyawan']);
        $menu = Menu::first();

        $pesanan = Pesanan::create([
            'nama_pembeli' => 'Alice',
            'nomor_meja' => 'Meja 2',
            'menu_id' => $menu->id,
            'jumlah' => 1,
            'total_harga' => $menu->harga,
            'metode_pembayaran' => 'QRIS',
            'status_pembayaran' => 'Sudah Dibayar',
            'status' => 'Diproses',
            'kode_pesanan' => 'POS261117TEST',
            'kasir_nama' => 'Budi',
        ]);

        $response = $this->actingAs($karyawan)->get(route('kasir.struk', 'POS261117TEST'));
        $response->assertStatus(200);
        $response->assertSee('NOIR COFFEE');
        $response->assertSee('POS261117TEST');
        $response->assertSee('Alice');
    }

    /**
     * Test menu updates by admin are immediately reflected in kasir menu list.
     */
    public function test_menu_updates_by_admin_are_reflected_in_kasir_catalog(): void
    {
        $karyawan = User::factory()->create(['role' => 'karyawan']);
        $menu = Menu::first();

        // Update menu details
        $menu->update([
            'nama_kopi' => 'Signature Kopi Khas Noir',
            'harga' => 35000,
        ]);

        $response = $this->actingAs($karyawan)->get(route('kasir.index'));
        $response->assertStatus(200);
        $response->assertSee('Signature Kopi Khas Noir');
        $response->assertSee('35.000');
    }

    /**
     * Test admin can manage employee accounts (create, edit, delete).
     */
    public function test_admin_can_manage_karyawan_accounts(): void
    {
        $admin = User::where('role', 'admin')->first() ?: User::factory()->create(['role' => 'admin']);

        // Create new karyawan
        $createResponse = $this->actingAs($admin)->post(route('admin.karyawan.store'), [
            'name' => 'Siti Kasir',
            'email' => 'siti@noircoffee.com',
            'password' => 'secret123',
            'role' => 'karyawan',
        ]);
        $createResponse->assertRedirect(route('admin.karyawan.index'));
        $this->assertDatabaseHas('users', ['email' => 'siti@noircoffee.com', 'role' => 'karyawan']);

        $siti = User::where('email', 'siti@noircoffee.com')->first();

        // Update karyawan
        $updateResponse = $this->actingAs($admin)->put(route('admin.karyawan.update', $siti->id), [
            'name' => 'Siti Aminah Kasir',
            'email' => 'siti@noircoffee.com',
            'role' => 'karyawan',
        ]);
        $updateResponse->assertRedirect(route('admin.karyawan.index'));
        $this->assertDatabaseHas('users', ['name' => 'Siti Aminah Kasir']);

        // Delete karyawan
        $deleteResponse = $this->actingAs($admin)->delete(route('admin.karyawan.destroy', $siti->id));
        $deleteResponse->assertRedirect(route('admin.karyawan.index'));
        $this->assertDatabaseMissing('users', ['id' => $siti->id]);
    }
}
