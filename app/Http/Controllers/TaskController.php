<?php

namespace App\Http\Controllers;

use App\Http\Requests\AssignTaskRequest;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Requests\UpdateTaskStatusRequest;
use App\Http\Resources\TaskResource;
use App\Services\TaskService;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Illuminate\Validation\Rules\Exists;

class TaskController extends Controller
{   protected $taskService;


    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }
    /**
     * Display a listing of the tasks.
     * 
     */
    public function index(Request $request)
    {   
      
        $priority = $request->input('priority');
        $status = $request->input('status');

        $tasks = Task::query();

        //if request has a priority apply filter scope by priority
        if ($priority) {
            $tasks->byPriority($priority);
        }
        //if request has a status apply filter scope by status
        if ($status) {
            $tasks->byStatus($status);
        }


       
        return response()->json([
            'status' => 'success',
            'message' => 'Tasks retrieved successfully',
            'data' => $tasks->get(),
        ], 200); // OK
    }

    /**
     * Store a newly task in storage.
     */
    public function store(StoreTaskRequest $request)
    { $validRequest=$request->validated();
      $task=$this->taskService->CreateTask($validRequest);
      
    
     return response()->json([
        'status' => 'success',
        'message' => 'task created successfully',
        'task' => $task,
    ], 201); // Created    
    
    }
    /**
     * Display the specified task.
     */
    public function show(String $id)
    {
        $fetchedData = $this->taskService->showTask($id);
        return response()->json([
            'status' => 'success',
            'message' => 'task retrieved successfully',
            'task' => $fetchedData,
        ], 200); // OK
    }

    /**
     * Update the task in storage.
     */
    public function update(UpdateTaskRequest $request, String $id)
    {
        $task=Task::findOrFail($id);
        if(!$task->exists)
        {
            return $this->notFound('task not found.');
        }
        $validatedRequest = $request->validated();
        $updatedTaskResource = $this->taskService->updateTask($task, $validatedRequest);
        return response()->json([
            'status' => 'success',
            'message' => 'task updated successfully',
            'task' => $updatedTaskResource,
        ], 200); // OK
    }

    /**
     * Remove the task from storage.
     */
    public function destroy(String $id)
    {
        $this->taskService->deleteTask($id);
        return response()->json([
            'status' => 'success',
            'message' => 'task deleted successfully',
            'task' => [],
        ], 200); // OK
    }


    public function assignTask(AssignTaskRequest $request, Task $task)
    { 
            $task->assigned_to = $request->input('assigned_to');
            $task->save();

            return response()->json(['message' => 'Task assigned successfully.'], 200);
        
    }


    public function updateStatus(UpdateTaskStatusRequest $request, Task $task)
    {
        $user = Auth::user();

        if ($user->id === $task->assigned_to) {
            $task->status = $request->input('status');
            $task->save();

         
            return response()->json([
                'status' => 'success',
                'message' => 'task status updated successfully',
                'task' => new TaskResource($task),
            ], 200); // OK
        }

        return response()->json(['message' => 'Unauthorized.'], 403);
    }
}
