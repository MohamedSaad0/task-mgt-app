<?php

namespace App\Http\Contracts;

interface TaskServiceInterface
{
    public function index($request);
    public function store(array $data);
    public function tasksAssignedToCurrentUser();
    public function updateTask(array $data, $task);
    public function updateTaskStatus(array $data, $task);
    public function addDependencies(array $data, $task);
    public function assignTask(array $data, $task);
    public function showDetails($task);
}
