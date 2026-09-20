<?php

namespace Database\Factories;

use App\Models\Activity;
use App\Models\ActivityCategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends Factory<Activity>
 */
class ActivityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startedAt = fake()->dateTimeBetween('-30 days');

        return [
            'user_id' => User::factory(),
            'category_id' => ActivityCategory::factory(),
            'description' => fake()->optional(0.8)->sentence(),
            'started_at' => $startedAt,
            'finished_at' => fake()->boolean(80)
                ? Carbon::instance($startedAt)->addMinutes(fake()->numberBetween(15, 240))
                : null,
        ];
    }
}
