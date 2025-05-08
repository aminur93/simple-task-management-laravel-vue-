<?php

namespace Tests\Feature;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class TaskFeatureTest extends TestCase
{
    use RefreshDatabase, WithoutMiddleware;

    /**
     * task index pagination test
    */
    public function test_task_index_pagination()
    {
        $response = $this->getJson('/api/v1/admin/task');

        // Assert the top-level structure and specific keys
        $response->assertJson([
            'success' => true,
            'message' => 'All task fetch successful with pagination',
            'status' => 200,
        ]);

        // Assert the presence of the `data` key
        $this->assertArrayHasKey('data', $response->json());
    }


    /**
     * task index without pagination test
    */
    public function test_task_index_without_pagination()
    {
        // Seed data
        $tasks = Task::factory()->count(10)->create();

         // Send request with pagination=false
         $response = $this->json('GET', '/api/v1/admin/task?pagination=false');

         // Assertions
         $response->assertStatus(200); // Ensure the status code is 200
 
         $response->assertJson([
             'success' => true,     
             'message' => 'All task fetch successful',
             'status' => 200
         ]);
 
         $this->assertArrayHasKey('data', $response->json());
    }

    /**
     * task store test
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

        $response = $this->postJson('/api/v1/admin/task', $taskData);

        $response->assertStatus(201)
                 ->assertJson([
                     'success' => true,
                     'message' => 'Store successful',
                     'status' => 201,
                 ]);
    }

    /**
     * task show test
    */
    public function test_task_show()
    {
        $task = Task::factory()->create();

        $response = $this->getJson('/api/v1/admin/task/' . $task->id);

        $response->assertStatus(200)
                 ->assertJson([
                     'success' => true,
                     'message' => 'Task fetch successful',
                     'status' => 200,
                 ]);
    }

    /**
     * task update test
    */
    public function test_task_update()
    {
        $task = Task::factory()->create();

        $updateData = [
            'title' => 'Updated Task',
            'body' => 'This is an updated task.',
            'is_completed' => true,
            'status' => false,
        ];

        $response = $this->putJson('/api/v1/admin/task/' . $task->id, $updateData);

        $response->assertStatus(200)
                 ->assertJson([
                     'success' => true,
                     'message' => 'Task update successful',
                     'status' => 200,
                 ]);
    }

    /**
     * task destroy test
    */
    public function test_task_destroy()
    {
        $task = Task::factory()->create();

        $response = $this->deleteJson('/api/v1/admin/task/' . $task->id);

        $response->assertStatus(200)
                 ->assertJson([
                     'success' => true,
                     'message' => 'Task delete successful',
                     'status' => 200,
                 ]);
    }

    /**
     * task change status test
    */
    public function test_task_change_status()
    {
        $task = Task::factory()->create();

        $response = $this->patchJson('/api/v1/admin/task/changeStatus/' . $task->id, [
            'status' => true,
        ]);

        $response->assertStatus(200)
                 ->assertJson([
                     'success' => true,
                     'message' => 'Task status change successful',
                     'status' => 200,
                 ]);
    }

    /**
     * task change complete status test
    */
    public function test_task_change_complete_status()
    {
        $task = Task::factory()->create();

        $response = $this->patchJson('/api/v1/admin/task/changeCompleteStatus/' . $task->id, [
            'is_completed' => true,
        ]);

        $response->assertStatus(200)
                 ->assertJson([
                     'success' => true,
                     'message' => 'Task complete status change successful',
                     'status' => 200,
                 ]);
    }

    /**
     * 
     * task validation rules test
    */
    public function test_task_validation_rules()
    {
        $data = [
            'title' => '',
            'body' => 'this is a test task.',
            'is_completed' => 'not a boolean',
            'status' => 'not a boolean',
            'created_by' => 'not a number'
        ];

        $response = $this->postJson('/api/v1/admin/task', $data);

        $response->assertStatus(422);
    }

    
}