<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\ActivityCategory;
use App\Models\User;
use Illuminate\Database\Seeder;

class ActivitySeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Activity::factory()
            ->count(500)
            ->recycle(User::all())
            ->recycle(ActivityCategory::all())
            ->create();
    }
}
