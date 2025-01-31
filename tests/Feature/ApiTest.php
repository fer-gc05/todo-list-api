<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApiTest extends TestCase
{
    use RefreshDatabase;

    protected function getAuthToken()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $loginData = [
            'email' => 'test@example.com',
            'password' => 'password',
        ];

        $response = $this->postJson('/api/login', $loginData);
        return $response->json('token');
    }


    public function test_register()
    {
        $userData = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $response = $this->postJson('/api/register', $userData);
        $response->assertStatus(201)
            ->assertJsonStructure([
                'success',
                'message',
                'user' => [
                    'id',
                    'name',
                    'email',
                    'created_at',
                    'updated_at',
                ],
            ])
            ->assertJson(['success' => true, 'message' => 'User registered successfully']);
    }


    public function test_login()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $loginData = [
            'email' => 'test@example.com',
            'password' => 'password',
        ];

        $response = $this->postJson('/api/login', $loginData);
        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'token',
            ])
            ->assertJson(['success' => true, 'message' => 'Login successful']);
    }


    public function test_logout()
    {
        $token = $this->getAuthToken();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/logout');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Successfully logged out',
            ]);
    }


    public function test_me()
    {
        $token = $this->getAuthToken();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->getJson('/api/me');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'user' => [
                    'id',
                    'name',
                    'email',
                    'created_at',
                    'updated_at',
                ],
            ])
            ->assertJson(['success' => true, 'message' => 'User retrieved successfully']);
    }


    public function test_index_tasks()
    {
        $token = $this->getAuthToken();
        $user = User::where('email', 'test@example.com')->first();

        Task::factory()->count(5)->create(['user_id' => $user->id]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->getJson('/api/tasks');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'tasks' => [
                    '*' => [
                        'id',
                        'title',
                        'description',
                        'user_id',
                        'created_at',
                        'updated_at',
                    ],
                ],
            ]);
    }


    public function test_show_task()
    {
        $token = $this->getAuthToken();
        $user = User::where('email', 'test@example.com')->first();

        $task = Task::factory()->create(['user_id' => $user->id]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->getJson("/api/tasks/{$task->id}");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'task' => [
                    'id',
                    'title',
                    'description',
                    'user_id',
                    'created_at',
                    'updated_at',
                ],
            ]);
    }


    public function test_store_task()
    {
        $token = $this->getAuthToken();

        $taskData = [
            'title' => 'Test Task',
            'description' => 'This is a test task',
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/tasks', $taskData);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'success',
                'task' => [
                    'id',
                    'title',
                    'description',
                    'user_id',
                    'created_at',
                    'updated_at',
                ],
            ]);
    }


    public function test_update_task()
    {
        $token = $this->getAuthToken();
        $user = User::where('email', 'test@example.com')->first();

        $task = Task::factory()->create(['user_id' => $user->id]);

        $updateData = [
            'title' => 'Updated Task',
            'description' => 'This task has been updated',
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->putJson("/api/tasks/{$task->id}", $updateData);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'task' => [
                    'id',
                    'title',
                    'description',
                    'user_id',
                    'created_at',
                    'updated_at',
                ],
            ])
            ->assertJson(['success' => true, 'message' => 'Task updated successfully']);
    }


    public function test_destroy_task()
    {
        $token = $this->getAuthToken();
        $user = User::where('email', 'test@example.com')->first();

        $task = Task::factory()->create(['user_id' => $user->id]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->deleteJson("/api/tasks/{$task->id}");

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Task deleted successfully',
            ]);
    }
}
