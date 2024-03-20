<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Task;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\TasksResource;
use App\Http\Requests\TaskStoreRequest;
use App\Http\Requests\TaskUpdateRequest;
use App\Http\Requests\TaskStatusUpdateRequest;

class TaskController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $tasks = TasksResource::collection(Task::get());
            return $this->success($tasks, "Data retrieved successfully");
        } catch (Exception $e) {

            return $this->error("", "No data were found", 404);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TaskStoreRequest $request)
    {
        $validated = $request->validated();
        $task = Task::create($validated);

        return $this->success($task, "New task created successfully", 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        $user = Auth::user();
        return TasksResource::collection(
            Task::all()->where('assignee_id', $user->id)
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateTask(TaskUpdateRequest  $request, Task $task)
    {
        try {
            $validated = $request->validated();
            $task->update([
                "title" => $validated['title'],
                'description' => $validated['description'],
                'assignee_id' => $validated['assignee_id'],
                'due_date_to' => $validated['due_date_to'],
            ]);

            return $this->success($task, 'Task updated successfully', 200);
        } catch (Exception $e) {
            return $this->error($e->getMessage(), 'Failed to update task', 500);
        }
    }

    public function updateTaskStatus(TaskStatusUpdateRequest  $request, Task $task)
    {
        try {
            $taskDependencies = $task->dependents;
            $dependetsCompleted = $taskDependencies->every(function ($task) {
                return $task->status === "completed";
            });

            $validated = $request->validated();
            if (!$dependetsCompleted) {
                $taskDependencies = $task->dependents;
                $data = $taskDependencies->pluck("title");
                return $this->error(['task title' => $data], 'Please complete the following tasks to current completed', 500);
            }

            $task->update([
                "status" => $validated['status'],
            ]);

            return $this->success($task, 'Task status updated successfully', 200);
        } catch (Exception $e) {
            return $this->error($e->getMessage(), 'Failed to update task status', 500);
        }
    }

    public function showDetails(Task $task)
    {
        try {
            $taskDetails = TasksResource::collection(Task::all()->where('id', $task->id));
            return $this->success($taskDetails, "Task details retrieved successfully", 200);
        } catch (Exception $e) {
            return $this->error("", 'Failed to update task', 500);
        }
    }
}
