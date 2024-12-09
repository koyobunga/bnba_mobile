<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
        'nama' => 'Usman',
            'username' => 'enum',
            'no_telp' => '0892349234899',
            'email' => 'enum@example.com',
            'password' => Hash::make('enum'),
            'tipe' => 5,
            'kode_kel' => 7503022006,
            'rt' => 1,
        ]);
    }
}
