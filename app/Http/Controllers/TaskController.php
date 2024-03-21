<?php

namespace App\Http\Controllers;

use Log;
use Exception;
use App\Models\Task;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\TaskStoreRequest;
use App\Http\Requests\TaskAssignRequest;
use App\Http\Requests\TaskUpdateRequest;
use App\Http\Contracts\TaskServiceInterface;
use App\Http\Requests\TaskDependencyRequest;
use App\Http\Requests\TaskStatusUpdateRequest;

class TaskController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     */

    protected $taskService;
    public function __construct(TaskServiceInterface $taskService)
    {
        $this->taskService = $taskService;
    }

    public function index(Request $request)
    {
        $authenticatedUser = Auth::user();
        if (!$authenticatedUser->is_admin) {
            return $this->error("", "Your are not authorized to perform this action", 403);
        }
        return $this->taskService->index($request);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TaskStoreRequest $request)
    {
        $authenticatedUser = Auth::user()->is_admin;
        if (!$authenticatedUser) {
            return $this->error("", "Your are not authorized to perform this action", 403);
        }

        $validated = $request->validated();
        return $this->taskService->store($validated);
    }

    /**
     * Display the specified resource.
     */
    public function tasksAssignedToCurrentUser()
    {
        return $categories = $this->taskService->tasksAssignedToCurrentUser();
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateTask(TaskUpdateRequest  $request, Task $task)
    {
        $validated = $request->validated();
        return $this->taskService->updateTask($validated, $task);
    }

    public function updateTaskStatus(TaskStatusUpdateRequest  $request, Task $task)
    {

        $authenticatedUser = Auth::user();
        $assignee_id = $task->assignee_id;
        if (!$authenticatedUser->is_admin && ($authenticatedUser->id !== $assignee_id)) {
            return $this->error("", "Your are not authorized to perform this action", 403);
        }

        $validated = $request->validated();
        return $this->taskService->updateTaskStatus($validated, $task);
    }

    public function addDependencies(TaskDependencyRequest $request, Task $task)
    {
        $validated = $request->validated();
        return $this->taskService->addDependencies($validated, $task);
    }

    public function assignTask(TaskAssignRequest $request, Task $task)
    {
        $validated = $request->validated();
        return $this->taskService->assignTask($validated, $task);
    }

    public function showDetails(Task $task)
    {
        return $this->taskService->showDetails($task);
    }
}
