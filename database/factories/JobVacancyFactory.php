<?php

namespace Database\Factories;

use App\Models\JobCategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class JobVacancyFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::where('role', 'admin')->first()?->id ?? User::factory(),
            'job_category_id' => JobCategory::inRandomOrder()->first()?->id ?? JobCategory::factory(),
            'title' => $this->faker->jobTitle(),
            'slug' => Str::slug($this->faker->jobTitle()) . '-' . uniqid(),
            'description' => $this->faker->paragraphs(3, true),
            'requirements' => $this->faker->paragraphs(2, true),
            'benefits' => $this->faker->sentence(),
            'salary_min' => $this->faker->numberBetween(10000, 20000),
            'salary_max' => $this->faker->numberBetween(20000, 40000),
            'employment_type' => $this->faker->randomElement(['full_time', 'part_time', 'contract', 'temporary']),
            'location' => 'Tagudin, Ilocos Sur',
            'company' => 'Municipal Government of Tagudin',
            'slots_available' => $this->faker->numberBetween(1, 5),
            'application_deadline' => $this->faker->dateTimeBetween('+1 week', '+2 months'),
            'is_active' => true,
            'is_open' => true,
        ];
    }
}
