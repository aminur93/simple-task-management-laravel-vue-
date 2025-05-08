<?php

namespace App\Providers;

use App\Http\Services\Api\V1\Admin\Task\TaskInterface;
use App\Http\Services\Api\V1\Admin\Task\TaskService;
use Illuminate\Support\ServiceProvider;

class TaskServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(TaskInterface::class, TaskService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}