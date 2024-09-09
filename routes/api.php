<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register',[AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:api');



//store,update and destroy task  by admin or manager
Route::group(['middleware' => ['auth:api', 'role:manager|admin']], function () {
    Route::post('tasks',[TaskController::class,'store']);
    Route::put('tasks/{task}',[TaskController::class,'update']);
    Route::delete('tasks/{task}',[TaskController::class,'destroy']);
    Route::get('tasks/{task}',[TaskController::class,'show']);
    Route::get('tasks',[TaskController::class,'index']);
});


//store,update and destroy user only by admin
Route::group(['middleware' => ['auth:api', 'role:admin']], function () {
    Route::post('users',[UserController::class,'store']);
    Route::put('users/{user}',[UserController::class,'update']);
    Route::delete('users/{user}',[UserController::class,'destroy']);
    Route::get('users/{user}',[UserController::class,'show']);
});

//define a route for task assigmement
Route::group(['middleware' => ['auth:api', 'role:manager']], function () {
Route::post('/tasks/{task}/assign', [TaskController::class, 'assignTask']); });

//update status task by user that assigned to it 
Route::patch('/tasks/{task}/status', [TaskController::class, 'updateStatus'])->middleware('auth');
