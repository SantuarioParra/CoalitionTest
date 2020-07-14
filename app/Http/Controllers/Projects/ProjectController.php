<?php

namespace App\Http\Controllers\Projects;

use App\Http\Controllers\Controller;
use App\Http\Requests\Projects\ProjectRequest;
use App\Services\Project\ProjectService;
use Illuminate\Http\Response;

class ProjectController extends Controller
{
    private $projectService;

    /**
     * Calling Service
     * @param ProjectService $projectService
     */
    public function __construct(ProjectService $projectService)
    {
        $this->projectService = $projectService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function index()
    {
        return $this->projectService->getAllProjects();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProjectRequest $request
     * @return Response
     */
    public function store(ProjectRequest $request)
    {
        return  $this->projectService->saveProject($request->validated());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        return $this->projectService->getProject($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProjectRequest $request
     * @param int $id
     * @return Response
     */
    public function update(ProjectRequest $request, $id)
    {
        return $this->projectService->updateProject($request->validated(),$id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        return $this->projectService->deleteProject($id);
    }
}
