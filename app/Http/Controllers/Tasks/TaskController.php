<?php

namespace App\Http\Controllers\Tasks;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tasks\TaskRequest;
use App\Http\Requests\Tasks\TasksPriorityRequest;
use App\Services\Task\TaskService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TaskController extends Controller
{
    private $taskService;

    /**
     * Calling Service
     * @param TaskService $taskService
     */
    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function index()
    {
        return $this->taskService->getAllTask();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TaskRequest $request
     * @return Response
     */
    public function store(TaskRequest $request)
    {
        return $this->taskService->saveTask($request->validated());
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return $this->taskService->getTask($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param TaskRequest $request
     * @param int $id
     * @return void
     */
    public function update(TaskRequest $request, $id)
    {
        return $this->taskService->updateTask($request->validated(),$id);
    }

    /**
     * Update the specified resources in storage.
     *
     * @param TaskRequest $request
     * @param int $id
     * @return void
     */
    public function updatePriority(TasksPriorityRequest $request)
    {
        return  $this->taskService->updateTasksPriority($request->validated());
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        return $this->taskService->deleteTask($id);
    }
}
