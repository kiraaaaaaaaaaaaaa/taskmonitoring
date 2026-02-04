<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\BudgetController;
use App\Models\Task;

Route::get('/Task', function () {
    return view('welcome');
});

Route::get('/', [AuthenticationController::class, 'index']);
Route::post('/', [AuthenticationController::class, 'authenticate']) -> name('login');
//Task Routes

Route::get('/Task/task/{date?}/{papM?}', [TaskController::class, 'index'])->name('task');
Route::get('/Task.createtask', [TaskController::class, 'create'])->name('new task');
Route::post('/Task', [TaskController::class, 'store'])->name('store');
Route::post('/Task/createtask', [TaskController::class, 'createPAP'])->name('createPAP');
Route::get('/Task/viewtask/{id}', [TaskController::class, 'viewTask']);
Route::get('/Task/pap/{year?}/{month?}', [TaskController::class, 'forpap'])->name('monitoring');
Route::get('/Task/mytask', [TaskController::class, 'mytask'])->name('my task');
Route::get('/Task/updatetask/{id}', [TaskController::class, 'viewupdateTask']);
Route::post('/Task/updatetask', [TaskController::class, 'update']) -> name('updatetask');
Route::get('/Task/toreview', [TaskController::class, 'toreview'])->name('review');
Route::get('/reports', [TaskController::class, 'reports']) ->name('Reports');
Route::post('/reports', [TaskController::class, 'generate'])->name('reports-generate');


//User routes
Route::get('/users', [UserController::class, 'index'])->name('user management');
Route::post('/users', [UserController::class, 'store'])->name('storeuser');

//budget routes
Route::get('/budget', [BudgetController::class, 'index'])->name('budget management');
Route::post('/budget', [BudgetController::class, 'store'])->name('budget store');


