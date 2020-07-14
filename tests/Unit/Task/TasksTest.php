<?php

namespace Tests\Unit\Task;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TasksTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @dataProvider provider
     */
    public function provider()
    {
        return  [
            "name" => "One test task",
            "priority" => 1,
        ];
    }

    /**
     * @test
     * @return void
     */
    public function createTask()
    {
        $this->post(route('tasks.store'),$this->provider())
            ->assertStatus(201);
    }

    /**
     * @test
     * @return void
     */
    public function getTask()
    {
        factory('App\Task')->create();
        $this->get(route('tasks.show',1),$this->provider())
            ->assertStatus(200);
    }

    /**
     * @test
     * @return void
     */
    public function updateTask()
    {
        factory('App\Task')->create();
        $this->patch(route('tasks.update',1),$this->provider())
            ->assertStatus(200);
    }

    /**
     * @test
     * @return void
     */
    public function deleteTask()
    {
        factory('App\Task')->create();
        $this->delete(route('tasks.destroy',1))
            ->assertStatus(200);
    }

}
