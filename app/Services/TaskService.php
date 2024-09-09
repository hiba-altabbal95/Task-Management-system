<?php

namespace App\Services;

use App\Http\Resources\TaskResource;
use Exception;
use App\Models\Task;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class TaskService {
 
    public function getAll(){
        try{
        $tasks=Task::get();
        return $tasks;
        }
        catch (Exception $e) {
            // Handle any exceptions that may occur
            return [
                'status' => 'error',
                'message' => 'An error occurred while retrieving tasks.',
                'errors' => $e->getMessage(),
            ];
        }

    }

    public function CreateTask(array $data)
    {
        try {
       
        
          return Task::create([
             'title' => $data['title'],
             'description' => $data['description'],
             'status' => $data['status'],
             'date_due' => $data['date_due'],
             'priority' => $data['priority'],
          ]);       
        } catch (Exception $e) {
            throw new Exception('Task creation failed: ' . $e->getMessage());
        }
          
    }

    public function showTask(int $id): Task
    {
        try {
            $task = Task::findOrFail($id);
            return $task;
        } catch (ModelNotFoundException $e) {
            throw new Exception('task not found: ' . $e->getMessage());
        } catch (Exception $e) {
            throw new Exception('Failed to retrieve task ' . $e->getMessage());
        }
    }

    public function updateTask(Task $task, array $data): array
    {   try{
        // Update only the fields that are provided in the data array
        $task->update(array_filter([
            'title' => $data['title'] ?? $task->title,
            'discription' => $data['discription'] ?? $task->discription,
            'status'=>$data['status']??$task->status,
            'assigned_to' => $data['assigned_to'] ?? $task->assigned_to,
            'date_due' => $data['date_due'] ?? $task->description,
            'priority' => $data['priority'] ?? $task->priority,
            
            
        ]));

        // Return the updated task as a resource
        return TaskResource::make($task)->toArray(request());
    }
    catch (Exception $e) {
        throw new Exception('Failed to update task ' . $e->getMessage());
    }

}
  /**
     * Delete a movie by its ID.
     * 
     * @param int $id
     * The ID of the task to delete.
     * 
     * @return void
     * 
     * @throws \Exception
     * Throws an exception if the task is not found.
     */
    public function deleteTask(int $id): void
    {
        // Find the task by ID
        $task = task::find($id);

        // If no movie is found, throw an exception
        if (!$task) {
            throw new \Exception('task not found.');
        }

        // soft Delete the task
        $task->delete();
    }

}