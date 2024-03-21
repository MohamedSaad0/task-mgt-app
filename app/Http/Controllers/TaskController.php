<?php

namespace App\Http\Controllers;

use Log;
use Exception;
use App\Models\Task;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
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
        $adminPrivilegeCheck = Gate::inspect('admin-privileges', [Auth::user()]);

        if (!$adminPrivilegeCheck->allowed()) {
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
        return $this->taskService->tasksAssignedToCurrentUser();
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateTask(TaskUpdateRequest  $request, Task $task)
    {

        $adminPrivilegeCheck = Gate::inspect('admin-privileges', [Auth::user()]);

        if (!$adminPrivilegeCheck->allowed()) {
            return $this->error("", "Your are not authorized to perform this action", 403);
        }
        $validated = $request->validated();
        return $this->taskService->updateTask($validated, $task);
    }

    public function updateTaskStatus(TaskStatusUpdateRequest  $request, Task $task)
    {
        $taskOwnerCheck  = Gate::inspect('task-owner', [$task, Auth::user()]);
        $adminPrivilegeCheck = Gate::inspect('admin-privileges', Auth::user());

        if ($taskOwnerCheck->allowed() || $adminPrivilegeCheck->allowed()) {

            $validated = $request->validated();
            return $this->taskService->updateTaskStatus($validated, $task);
        }
        return $this->error("", "Your are not authorized to perform this action", 403);
    }

    public function addDependencies(TaskDependencyRequest $request, Task $task)
    {
        $validated = $request->validated();
        return $this->taskService->addDependencies($validated, $task);
    }

    public function assignTask(TaskAssignRequest $request, Task $task)
    {
        $authCheck = Gate::inspect('admin-privileges', Auth::user());
        if ($authCheck->allowed()) {
            $validated = $request->validated();
            return $this->taskService->assignTask($validated, $task);
        } else {
            return $this->error("", "Your are not authorized to perform this action", 403);
        }
    }

    public function showDetails(Task $task)
    {
        return $this->taskService->showDetails($task);
    }
}
