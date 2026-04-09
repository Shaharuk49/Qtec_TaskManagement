<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a default user to own all seeded tasks
        $user = User::firstOrCreate(
            ['email' => 'demo@taskflow.test'],
            [
                'name'     => 'Demo User',
                'password' => bcrypt('password'),
            ]
        );

        // Create a spread of tasks across all statuses and priorities
        Task::factory()->count(5)->pending()->create(['user_id' => $user->id]);
        Task::factory()->count(4)->inProgress()->create(['user_id' => $user->id]);
        Task::factory()->count(6)->completed()->create(['user_id' => $user->id]);
        Task::factory()->count(3)->overdue()->create(['user_id' => $user->id]);
        Task::factory()->count(2)->highPriority()->create(['user_id' => $user->id]);
    }
}