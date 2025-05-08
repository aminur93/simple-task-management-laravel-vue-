<?php

namespace Tests\Unit;

use App\Http\Services\Api\V1\Admin\Task\TaskService;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\Request;
//use PHPUnit\Framework\TestCase;
use Tests\TestCase;

class TaskUnitTest extends TestCase
{
    use RefreshDatabase, WithoutMiddleware;

    /**
     * task paginator test
     */
    public function test_task_paginator()
    {
        // Creating fake permissions in the database
        Task::factory()->count(20)->create();

        // Creating a fake Request object
        $request = new Request([
            'sortBy' => 'title',
            'sortDesc' => 'false',
            'itemsPerPage' => 10,
            'page' => 1,
        ]);

        // Instantiate the PermissionService
        $taskService = new TaskService();

        // Call the index method
        $result = $taskService->index($request);

        // Assertions
        $this->assertEquals(1, $result->currentPage());
        $this->assertEquals(10, $result->perPage());
        $this->assertEquals(20, $result->total());
        $this->assertCount(10, $result->items());
    }

    /**
     * task all test
     */
    public function test_task_all()
    {
        // Create 30 tasks
        $task = Task::factory()->count(30)->create();

        $taskService = new TaskService();
        $result = $taskService->getAllTasks();

        // Sort both by created_at desc to match Task::latest()
        $expected = $task->sortByDesc('id')->pluck('id')->values();
        $actual = $result->pluck('id')->values();

        $this->assertEquals($expected, $actual);
    }

    /**
     * task store unit test
     */
    public function test_task_store()
    {
        $taskData = [
            'title' => 'Test Task',
            'body' => 'This is a test task.',
            'is_completed' => false,
            'status' => true,
            'created_by' => 1,
        ];

        $request = new Request($taskData);

        $taskService = new TaskService();
        $result = $taskService->store($request);

        // Assertions
        $this->assertInstanceOf(Task::class, $result);
        $this->assertEquals($taskData['title'], $result['title']);
        $this->assertEquals($taskData['body'], $result['body']);
    }

    /**
     * task show unit test
     */
    public function test_task_show()
    {
        $task = Task::factory()->create();

        $taskService = new TaskService();
        $result = $taskService->show($task->id);

        // Assertions
        $this->assertInstanceOf(Task::class, $result);
        $this->assertEquals($task->id, $result['id']);
    }

    /**
     * task update unit test
     */
    public function test_task_update()
    {
        $task = Task::factory()->create();

        $taskData = [
            'title' => 'Updated Task',
            'body' => 'This is an updated task.',
            'is_completed' => true,
            'status' => false,
            'created_by' => 1,
        ];

        $request = new Request($taskData);

        $taskService = new TaskService();
        $result = $taskService->update($request, $task->id);

        // Assertions
        $this->assertInstanceOf(Task::class, $result);
        $this->assertEquals($taskData['title'], $result['title']);
        $this->assertEquals($taskData['body'], $result['body']);
    }

    /**
     * task delete unit test
     */
    public function test_task_delete()
    {
        $task = Task::factory()->create();

        $taskService = new TaskService();
        $result = $taskService->destroy($task->id);

        $this->assertTrue($result);
        $this->assertNull(Task::find($task->id));
    }

    /**
     * task change status unit test
     */
    public function test_task_change_status()
    {
        $task = Task::factory()->create();

        $taskData = [
            'status' => true,
        ];

        $request = new Request($taskData);

        $taskService = new TaskService();
        $result = $taskService->changeStatus($request, $task->id);

        // Assertions
        $this->assertInstanceOf(Task::class, $result);
        $this->assertEquals($taskData['status'], $result['status']);
    }

    /**
     * task change complete status unit test
     */
    public function test_task_change_complete_status()
    {
        $task = Task::factory()->create();

        $taskData = [
            'is_completed' => true,
        ];

        $request = new Request($taskData);

        $taskService = new TaskService();
        $result = $taskService->changeCompleteStatus($request, $task->id);

        // Assertions
        $this->assertInstanceOf(Task::class, $result);
        $this->assertEquals($taskData['is_completed'], $result['is_completed']);
    }
}