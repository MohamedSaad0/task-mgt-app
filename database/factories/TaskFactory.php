<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "title" => $this->faker->sentence(),
            "description" => $this->faker->text(),
            "status" => $this->faker->randomElement(["pending", "completed", "canceled"]),
            "assignee_id" => User::inRandomOrder()->first()->id,
            "dependency_of" => null,
            "due_date_from" => $this->faker->dateTimeBetween('now', '+1 week'),
            "due_date_to" => $this->faker->dateTimeBetween('+1 week', '+2 weeks')
        ];
    }
}
