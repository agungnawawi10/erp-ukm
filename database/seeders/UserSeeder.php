<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Agung Nawawi',
            'email' => 'admin@erpukm.com',
            'password' => Hash::make('password'), // Password untuk login
            'phone' => '081234567890',
            'position' => 'Super Admin',
            'is_active' => true,
        ]);

        // 2. Membuat 10 User dummy tambahan secara acak
        User::factory(10)->create();
    }
}
