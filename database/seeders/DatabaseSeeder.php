<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'admin',
                'password' => bcrypt('password'),
                'role' => 'admin',
            ]
        );

        User::firstOrCreate(
            ['email' => 'kasir@gmail.com'],
            [
                'name' => 'Kasir Noir',
                'password' => bcrypt('password'),
                'role' => 'karyawan',
            ]
        );

        User::firstOrCreate(
            ['email' => 'fahmi@gmail.com'],
            [
                'name' => 'fahmi',
                'password' => bcrypt('password'),
                'role' => 'pelanggan',
            ]
        );

        User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => bcrypt('password'),
                'role' => 'pelanggan',
            ]
        );

        $this->call([
            MenuSeeder::class,
            CoffeeExpertSystemSeeder::class,
            CbrCaseSeeder::class,
            BahanBakuSeeder::class,
        ]);
    }
}
