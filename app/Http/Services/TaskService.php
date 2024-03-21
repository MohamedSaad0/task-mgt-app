<?php

namespace App\Http\Services;

use Exception;
use App\Models\Task;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\TasksResource;
use App\Http\Contracts\TaskServiceInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TaskService implements TaskServiceInterface
{
    use HttpResponses;
    public function index($request)
    {
        try {

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

            $filteredTasks = TasksResource::collection($tasks->get());
            return $this->success($filteredTasks, "Data retrieved successfully");
        } catch (Exception $e) {

            return $this->error("", "No data were found", 404);
        }
    }

    public function store(array $data)
    {
        try {
            $task = Task::create($data);
            return $this->success($task, "New task created successfully", 201);
        } catch (Exception $e) {
            return $this->error("", 'Failed to create task', 500);
        }
    }

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

    public function updateTask(array $data, $task)
    {
        try {
            $task->update([
                "title" => $data['title'],
                'description' => $data['description'],
                'assignee_id' => $data['assignee_id'],
                'due_date_to' => $data['due_date_to'],
            ]);

            return $this->success($task, 'Task updated successfully', 200);
        } catch (ModelNotFoundException $e) {
            return $this->error("", 'Invalid task id', 404);
        } catch (Exception $e) {
            return $this->error("", 'Failed to update task', 500);
        }
    }
    public function updateTaskStatus(array $data, $task)
    {
        try {
            $taskDependencies = $task->dependents;
            $dependetsCompleted = $taskDependencies->every(function ($task) {
                return $task->status === "completed";
            });

            if (!$dependetsCompleted) {
                $taskDependencies = $task->dependents;
                $data = $taskDependencies->pluck("title", "id");
                return $this->success([$data], 'Please complete the following tasks to mark the current completed', 200);
            }

            $task->update([
                "status" => $data['status'],
            ]);

            return $this->success($task, 'Task status updated successfully', 200);
        } catch (Exception $e) {
            return $this->error($e->getMessage(), 'Failed updating task status', 400);
        }
    }

    public function addDependencies(array $data, $task)
    {
        try {
            $task->update([
                "dependency_of" => $data["dependency_of"]
            ]);

            return $this->success($task, 'Task dependencies updated successfully', 200);
        } catch (Exception $e) {
            return $this->error("", "Invalid task", 400);
        }
    }
    public function assignTask(array $data, $task)
    {
        try {
            if ($data) {
                $task->update([
                    "assignee_id" => $data["assignee_id"]
                ]);
                return $this->success($task, "Task assigned successfully", 200);
            }
        } catch (Exception $e) {
            return $this->error("", "Failed to assign task", 400);
        }
    }
    public function showDetails($task)
    {
        try {
            $taskDetails = TasksResource::collection(Task::all()->where('id', $task->id));
            return $this->success($taskDetails, "Task details retrieved successfully", 200);
        } catch (Exception $e) {
            return $this->error("", 'Failed to update task', 500);
        }
    }
}
