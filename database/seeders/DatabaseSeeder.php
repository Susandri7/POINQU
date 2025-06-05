<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seeder Admin
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@poinqu.com',
            'password' => bcrypt('Su54ndri72'), // Ganti password sesuai kebutuhan
            'role' => 'admin',
        ]);

        // Seeder UMKM contoh 1
        User::factory()->create([
            'name' => 'UMKM Sukses',
            'email' => 'umkm1@example.com',
            'password' => bcrypt('12345678'),
            'role' => 'umkm',
        ]);

        // Seeder UMKM contoh 2
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('12345678'),
            'role' => 'umkm',
        ]);

        // Jika ingin generate random user umkm tambahan:
        // User::factory(10)->create(['role' => 'umkm']);
    }
}