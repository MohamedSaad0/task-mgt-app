<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Task;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\TasksResource;

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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        $user = Auth::user()->id;
        return $user->tasks;
        return TasksResource::collection(
            Task::where('assignee_id', Auth::user()->id)->get()
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        //
    }
}
