<?php


namespace App\Services\Project;


use App\Project;
use http\Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProjectService
{
    private $project;

    public function __construct(Project $project)
    {
        $this->project = $project;
    }

    public function getAllProjects(){
        try{
            $projects = $this->project->withoutTrashed()->get();
            return response()->json(['projects'=>$projects],200);

        }catch (Exception $exception){
            return response()->json(['message'=>trans('messages.500_INTERNAL_ERROR').$exception],500);
        }
    }
    public function saveProject($validatedRequest)
    {
        try{
            $project = $this->project->fill($validatedRequest);
            return $project->save()?
                response()->json(['message'=>trans('messages.201_CREATE_PROJECT')],201):
                response()->json(['message'=>trans('messages.400_CREATE_PROJECT')],400);
        }catch (Exception $exception){
            return response()->json(['message'=>trans('messages.500_INTERNAL_ERROR').$exception],500);
        }
    }

    public function getProject($id)
    {
        try{
            $project = $this->project->findOrFail($id);
            return response()->json(['project'=>$project],200);
        }catch (ModelNotFoundException $exception){
            return response()->json(['message'=>trans('messages.404_PROJECT_NOT_FOUND')],404);
        }catch (Exception $exception){
            return response()->json(['message'=>trans('messages.500_INTERNAL_ERROR').$exception],500);
        }
    }

    public function updateProject($validatedRequest, $id)
    {
        try{
            $project = $this->project->findOrFail($id);
            $project->fill($validatedRequest);
            return $project->save()?
                response()->json(['message'=>trans('messages.200_UPDATE_PROJECT')],200):
                response()->json(['message'=>trans('messages.400_UPDATE_PROJECT')],400);
        }catch (ModelNotFoundException $exception){
            return response()->json(['message'=>trans('messages.404_PROJECT_NOT_FOUND')],404);
        }catch (Exception $exception){
            return response()->json(['message'=>trans('messages.500_INTERNAL_ERROR').$exception],500);
        }
    }

    public function deleteProject($id)
    {
        try{
            $project = $this->project->findOrFail($id);
            return $project->delete()?
                response()->json(['message'=>trans('messages.200_DELETE_PROJECT')],200):
                response()->json(['message'=>trans('messages.400_DELETE_PROJECT')],400);
        }catch (ModelNotFoundException $exception){
            return response()->json(['message'=>trans('messages.404_PROJECT_NOT_FOUND')],404);
        }catch (Exception $exception){
            return response()->json(['message'=>trans('messages.500_INTERNAL_ERROR').$exception],500);
        }
    }

    public function restoreProject($id)
    {
        try{
            $project = $this->project->withTrashed()->findOrFail($id);
            return $project->restore()?
                response()->json(['message'=>trans('messages.200_RESTORE_PROJECT')],200):
                response()->json(['message'=>trans('messages.400_RESTORE_PROJECT')],400);
        }catch (ModelNotFoundException $exception){
            return response()->json(['message'=>trans('messages.404_PROJECT_NOT_FOUND')],404);
        }catch (Exception $exception){
            return response()->json(['message'=>trans('messages.500_INTERNAL_ERROR').$exception],500);
        }
    }
}
