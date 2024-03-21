<?php

namespace App\Providers;

use App\Http\Services\TaskService;

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
        //
    }
}
