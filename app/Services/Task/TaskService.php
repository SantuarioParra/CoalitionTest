<?php

namespace App\Services\Task;

use App\Task;
use http\Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TaskService
{
    private $task;

    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    public function getAllTask()
    {
        try {
            $tasks = $this->task->withoutTrashed()->oldest('priority')->get();
            return response()->json(['tasks' => $tasks], 200);
        } catch (Exception $exception) {
            return response()->json(['message' => trans('messages.500_INTERNAL_ERROR') . $exception], 500);
        }
    }

    public function saveTask($validatedRequest)
    {
        try {
            $task = $this->task->fill($validatedRequest);
            return $task->save() ?
                response()->json(['message' => trans('messages.201_CREATE_TASK')], 201) :
                response()->json(['message' => trans('messages.400_CREATE_TASK')], 400);
        } catch (Exception $exception) {
            return response()->json(['message' => trans('messages.500_INTERNAL_ERROR') . $exception], 500);
        }
    }

    public function getTask($id)
    {
        try {
            $task = $this->task->findOrFail($id);
            return response()->json(['task' => $task], 200);
        } catch (ModelNotFoundException $exception) {
            return response()->json(['message' => trans('messages.404_TASK_NOT_FOUND')], 404);
        } catch (Exception $exception) {
            return response()->json(['message' => trans('messages.500_INTERNAL_ERROR') . $exception], 500);
        }
    }

    public function updateTask($validatedRequest, $id)
    {
        try {
            $task = $this->task->findOrFail($id);
            $task->fill($validatedRequest);
            return $task->save() ?
                response()->json(['message' => trans('messages.200_UPDATE_TASK')], 200) :
                response()->json(['message' => trans('messages.400_UPDATE_TASK')], 400);
        } catch (ModelNotFoundException $exception) {
            return response()->json(['message' => trans('messages.404_TASK_NOT_FOUND')], 404);
        } catch (Exception $exception) {
            return response()->json(['message' => trans('messages.500_INTERNAL_ERROR') . $exception], 500);
        }
    }

    public function updateTasksPriority($validatedRequest)
    {
        try {
            foreach ($validatedRequest['taskPriorities'] as $item) {
                $task = $this->task->find($item['id']);
                if ($task != null){
                    $task->priority = $item['priority'];
                    $task->save();
                }
            }
           return response()->json(['message' => trans('messages.200_UPDATE_TASK')], 200);
        } catch (Exception $exception) {
            return response()->json(['message' => trans('messages.500_INTERNAL_ERROR') . $exception], 500);
        }
    }

    public function deleteTask($id)
    {
        try {
            $task = $this->task->findOrFail($id);
            return $task->delete() ?
                response()->json(['message' => trans('messages.200_DELETE_TASK')], 200) :
                response()->json(['message' => trans('messages.400_DELETE_TASK')], 400);
        } catch (ModelNotFoundException $exception) {
            return response()->json(['message' => trans('messages.404_TASK_NOT_FOUND')], 404);
        } catch (Exception $exception) {
            return response()->json(['message' => trans('messages.500_INTERNAL_ERROR') . $exception], 500);
        }
    }

    public function restoreTask($id)
    {
        try {
            $task = $this->task->withTrashed()->findOrFail($id);
            return $task->restore() ?
                response()->json(['message' => trans('messages.200_RESTORE_TASK')], 200) :
                response()->json(['message' => trans('messages.400_RESTORE_TASK')], 400);
        } catch (ModelNotFoundException $exception) {
            return response()->json(['message' => trans('messages.404_TASK_NOT_FOUND')], 404);
        } catch (Exception $exception) {
            return response()->json(['message' => trans('messages.500_INTERNAL_ERROR') . $exception], 500);
        }
    }
}
