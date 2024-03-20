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
                "due_date_from" => now(),
                "due_date_to" => now()->addDays(7)
            ],
            [
                "title" => "Going to work",
                "description" => "Description for Task 2",
                "status" => "pending",
                "assignee_id" => 1,
                "dependency_of" => 1,
                "due_date_from" => now(),
                "due_date_to" => now()->addDays(4)
            ],
            [
                "title" => "Waking up",
                "description" => "Description for Task 3",
                "status" => "completed",
                "assignee_id" => 1,
                "dependency_of" => 2,
                "due_date_from" => now()->addDays(10),
                "due_date_to" => now()->addDays(15)
            ],
            [
                "title" => "Writing SRS",
                "description" => "Description for Task 1",
                "status" => "completed",
                "assignee_id" => 2,
                "dependency_of" => null,
                "due_date_from" => now()->addDays(2),
                "due_date_to" => now()->addDays(3)
            ],
            [
                "title" => "Making URS",
                "description" => "Description for Task 1",
                "status" => "pending",
                "assignee_id" => 2,
                "dependency_of" => 5,
                "due_date_from" => now()->addDays(20),
                "due_date_to" => now()->addDays(23)
            ]
        ]);
    }
}
