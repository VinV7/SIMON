<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Admin::factory()->create([
            'email' => 'admin@example.com',
            'name' => 'Admin',
            'password' => 'admin123',
        ]);
    }
}
