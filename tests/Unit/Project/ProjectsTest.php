<?php

namespace Tests\Unit\Project;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectsTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @dataProvider provider
     */
    public function provider()
    {
        return  [
            "name" => "Project 1",
        ];
    }

    /**
     * @test
     * @return void
     */
    public function createProject()
    {
        $this->post(route('projects.store'),$this->provider())
            ->assertStatus(201);
    }

    /**
     * @test
     * @return void
     */
    public function getProject()
    {
        factory('App\Project')->create();
        $this->get(route('projects.show',1),$this->provider())
            ->assertStatus(200);
    }

    /**
     * @test
     * @return void
     */
    public function updateProject()
    {
        factory('App\Project')->create();
        $this->patch(route('projects.update',1),$this->provider())
            ->assertStatus(200);
    }

    /**
     * @test
     * @return void
     */
    public function deleteProject()
    {
        factory('App\Project')->create();;
        $this->delete(route('projects.destroy',1))
            ->assertStatus(200);
    }
}
