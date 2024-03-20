<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'description', 'status', 'assignee_id', 'dependency_of', 'due_date_from', 'due_date_to'];

    public function user()
    {
        return $this->belongsTo(User::class, 'assignee_id');
    }

    public function dependencyOf()
    {
        return $this->belongsTo(Task::class, 'dependency_of');
    }

    public function dependents() // Retrieve tasks that must be completed to complete the current task
    {
        return $this->hasMany(Task::class, 'dependency_of');
    }
}
