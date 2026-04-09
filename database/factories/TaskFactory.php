<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'user_id'     => User::factory(), // creates a new user if none provided
            'title'       => $this->faker->sentence(rand(3, 7), false),
            'description' => $this->faker->optional(0.7)->paragraph(),
            'status'      => $this->faker->randomElement(Task::STATUSES),
            'priority'    => $this->faker->randomElement(Task::PRIORITIES),
            'due_date'    => $this->faker->optional(0.6)->dateTimeBetween('-7 days', '+30 days'),
        ];
    }

    public function pending(): static
    {
        return $this->state(['status' => 'pending']);
    }

    public function inProgress(): static
    {
        return $this->state(['status' => 'in_progress']);
    }

    public function completed(): static
    {
        return $this->state(['status' => 'completed']);
    }

    public function highPriority(): static
    {
        return $this->state(['priority' => 'high']);
    }

    public function overdue(): static
    {
        return $this->state([
            'due_date' => $this->faker->dateTimeBetween('-30 days', '-1 day'),
            'status'   => $this->faker->randomElement(['pending', 'in_progress']),
        ]);
    }
}