<?php

namespace App\Http\Controllers;

use Log;
use Exception;
use App\Models\Task;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\TasksResource;
use App\Http\Requests\TaskStoreRequest;
use App\Http\Requests\TaskAssignRequest;
use App\Http\Requests\TaskUpdateRequest;
use App\Http\Requests\TaskDependencyRequest;
use App\Http\Requests\TaskStatusUpdateRequest;

class TaskController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $authenticatedUser = Auth::user();
            if (!$authenticatedUser->is_admin) {
                return $this->error("", "Your are not authorized to perform this action", 403);
            }

            $status = $request->query('status');
            $assigneeId = $request->query('assignee_id');
            $dueDateFrom = $request->query('due_date_from');
            $dueDateTo = $request->query('due_date_to');

            $tasks = Task::query();

            if ($status) {
                $tasks->where('status', $request->status);
            }

            if ($assigneeId) {
                $tasks->where('assignee_id', '=', $request->assignee_id);
            }

            if ($dueDateFrom) {
                $tasks->where('due_date_from', '>=', $request->due_date_from);
            }
            if ($dueDateTo) {
                $tasks->where('due_date_to', '<=', $request->due_date_to);
            }
            // return $dueDateTo;
            // return  $sql = $tasks->toSql();

            $filteredTasks = TasksResource::collection($tasks->get());
            return $this->success($filteredTasks, "Data retrieved successfully");
        } catch (Exception $e) {

            return $this->error("", "No data were found", 404);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TaskStoreRequest $request)
    {
        $authenticatedUser = Auth::user()->is_admin;
        // return $authenticatedUser;
        if (!$authenticatedUser) {
            return $this->error("", "Your are not authorized to perform this action", 403);
        }
        try {
            $validated = $request->validated();
            $task = Task::create($validated);

            return $this->success($task, "New task created successfully", 201);
        } catch (Exception $e) {
            return $this->error("", 'Failed to create task', 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function tasksAssignedToCurrentUser()
    {
        try {

            $user = Auth::user();
            return TasksResource::collection(
                Task::all()->where('assignee_id', $user->id)
            );
        } catch (Exception $e) {
            return $this->error('', 'Failed to assign task', 500);
        }
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
            return $this->error("", 'Failed to update task', 500);
        }
    }

    public function updateTaskStatus(TaskStatusUpdateRequest  $request, Task $task)
    {

        $authenticatedUser = Auth::user();
        $assignee_id = $task->assignee_id;
        // return $authenticatedUser;
        if (!$authenticatedUser->is_admin && ($authenticatedUser->id !== $assignee_id)) {
            return $this->error("", "Your are not authorized to perform this action", 403);
        }

        try {
            $taskDependencies = $task->dependents;
            $dependetsCompleted = $taskDependencies->every(function ($task) {
                return $task->status === "completed";
            });

            $validated = $request->validated();
            if (!$dependetsCompleted) {
                $taskDependencies = $task->dependents;
                $data = $taskDependencies->pluck("title", "id");
                return $this->success([$data], 'Please complete the following tasks to mark the current completed', 200);
            }

            $task->update([
                "status" => $validated['status'],
            ]);

            return $this->success($task, 'Task status updated successfully', 200);
        } catch (Exception $e) {
            return $this->error($e->getMessage(), 'Failed updating task status', 400);
        }
    }

    public function addDependencies(TaskDependencyRequest $request, Task $task)
    {
        try {
            $validated = $request->validated();
            $task->update([
                "dependency_of" => $validated["dependency_of"]
            ]);

            return $this->success($task, 'Task dependencies updated successfully', 200);
        } catch (Exception $e) {
            return $this->error("", "Invalid task", 400);
        }
    }

    public function assignTask(TaskAssignRequest $request, Task $task)
    {
        try {
            $validated = $request->validated();
            if ($validated) {
                $task->update([
                    "assignee_id" => $validated["assignee_id"]
                ]);
                return $this->success($task, "Task assigned successfully", 200);
            }
        } catch (Exception $e) {
            return $this->error("", "Failed to assign task", 400);
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
