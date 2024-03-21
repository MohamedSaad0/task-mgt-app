<?php

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Task::factory(10)->create();
        Task::insert([

            [
                "title" => "Creating a Div",
                "description" => "Description for Task 1",
                "status" => "pending",
                "assignee_id" => 1,
                "dependency_of" => null,
                "due_date_from" => now()->startOfDay()->addHours(mt_rand(9, 14)),
                "due_date_to" => now()->startOfDay()->addDays(7)->addHours(mt_rand(9, 14))
            ],
            [
                "title" => "Going to work",
                "description" => "Description for Task 2",
                "status" => "pending",
                "assignee_id" => 1,
                "dependency_of" => 1,
                "due_date_from" => now()->startOfDay()->addDays(2)->addHours(mt_rand(9, 14)),
                "due_date_to" => now()->startOfDay()->addDays(7)->addHours(mt_rand(9, 14))
            ],
            [
                "title" => "Waking up",
                "description" => "Description for Task 3",
                "status" => "completed",
                "assignee_id" => 1,
                "dependency_of" => 2,
                "due_date_from" => now()->startOfDay()->addDays(5)->addHours(mt_rand(9, 14)),
                "due_date_to" => now()->startOfDay()->addDays(10)->addHours(mt_rand(9, 14))
            ],
            [
                "title" => "Writing SRS",
                "description" => "Description for Task 1",
                "status" => "completed",
                "assignee_id" => 2,
                "dependency_of" => null,
                "due_date_from" => now()->startOfDay()->addDays(10)->addHours(mt_rand(9, 14)),
                "due_date_to" => now()->startOfDay()->addDays(12)->addHours(mt_rand(9, 14))
            ],
            [
                "title" => "Making URS",
                "description" => "Description for Task 1",
                "status" => "pending",
                "assignee_id" => 2,
                "dependency_of" => 5,
                "due_date_from" => now()->startOfDay()->addDays(3)->addHours(mt_rand(9, 14)),
                "due_date_to" => now()->startOfDay()->addDays(4)->addHours(mt_rand(9, 14))
            ]
        ]);
    }
}
