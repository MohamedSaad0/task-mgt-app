<?php

namespace App\Providers;

use App\Models\Task;

use App\Models\User;
use App\Http\Services\TaskService;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use App\Http\Contracts\TaskServiceInterface;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            TaskServiceInterface::class,
            TaskService::class,
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('admin-privileges', function (User $user) {
            return $user->is_admin
                ? Response::allow()
                : Response::deny('Your are not authorized to perform this action');
        });

        Gate::define('task-owner', function (User $user, Task $task) {
            if ($task->assignee_id == $user->id) {
                return true;
            } else {
                return false;
            }
        });
    }
}
