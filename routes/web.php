<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\GoogleController;
use App\Models\Task;

Route::get('/Task', [TaskController::class, 'dashboard']) -> name('dashboard');

Route::get('/', [AuthenticationController::class, 'index']);
Route::post('/', [AuthenticationController::class, 'authenticate']) -> name('login');
Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('/auth/google/callback', [GoogleController::class, 'handleGooglCallbak'])->name('google.callback');
Route::post('/logout', [GoogleController::class, 'logout'])->name('logout');

//Task Routes
Route::get('/Task/task/{date?}/{papM?}', [TaskController::class, 'index'])->name('task');
Route::get('/Task.createtask/{id}', [TaskController::class, 'newcreate'])->name('new task');
Route::post('/Task', [TaskController::class, 'store'])->name('store');
Route::post('/Task/createtask', [TaskController::class, 'createPAP'])->name('createPAP');
Route::post('/papmangement/pap/{papID}', [TaskController::class, 'deletePAP'])->name('deletePAP');
Route::post('/papmangement/task/{tasksID}', [TaskController::class, 'deleteTasks']);
Route::get('/Task/viewtask/{id}', [TaskController::class, 'viewTask']);
Route::get('/Task/pap/{year?}/{month?}', [TaskController::class, 'forpap'])->name('task disposition');
Route::get('/Task/mytask', [TaskController::class, 'mytask'])->name('my task');
Route::get('/Task/updatetask/{id}', [TaskController::class, 'viewupdateTask']);
Route::post('/Task/updatetask', [TaskController::class, 'update']) -> name('updatetask');
Route::get('/Task/toreview', [TaskController::class, 'toreview'])->name('review');
Route::get('/reports', [TaskController::class, 'reports']) ->name('Reports');
Route::post('/reports', [TaskController::class, 'generate'])->name('reports-generate');
Route::get('/papmangement', [TaskController::class, 'papmanagement'])->name('pap management');
Route::post('/Task/pap', [TaskController::class, 'savePAP'])->name('savePAP');
Route::post('/Task/task/{id}', [TaskController::class, 'removepaptask'])->name('deletetask');
Route::post('/Task/pap/{id}', [TaskController::class, 'deletepapmanagement'])->name('deletepapmanagement');


//User routes
Route::get('/users', [UserController::class, 'index'])->name('user management');
Route::post('/users', [UserController::class, 'store'])->name('storeuser');

//budget routes
Route::get('/budget', [BudgetController::class, 'index'])->name('budget management');
Route::post('/budget', [BudgetController::class, 'store'])->name('budget store');
Route::post('/budget/adjust', [BudgetController::class, 'adjustbudget'])->name('adjustbudget');

//sector routes
Route::get('/sectormanagement', [App\Http\Controllers\SectorController::class, 'index'])->name('sector management');
Route::post('/sectormanagement', [App\Http\Controllers\SectorController::class, 'store'])->name('storesector');
Route::post('/sectormanagement/division', [App\Http\Controllers\SectorController::class, 'storeDivision'])->name('storedivision');
Route::post('/sectormanagement/division/{id}', [App\Http\Controllers\SectorController::class, 'deleteDivision'])->name('deletdivision');
Route::post('/sectormanagement/sector/{id}', [App\Http\Controllers\SectorController::class, 'deleteSector'])->name('deletesector');

//obex routes
Route::get('/obexmanagement', [App\Http\Controllers\OBEXcontroller::class, 'index'])->name('obex management');
Route::post('/obexmanagement/storeprogram', [App\Http\Controllers\OBEXcontroller::class, 'storeprogram'])->name('storeprogram');
Route::post('/obexmanagement/storesubprogram', [App\Http\Controllers\OBEXcontroller::class, 'storesubprogram'])->name('storesubprogram');
Route::post('/obexmanagement/storeobex', [App\Http\Controllers\OBEXcontroller::class, 'storeobex'])->name('storeobex');
Route::post('/obexmanagement/program/{id}', [App\Http\Controllers\OBEXcontroller::class, 'deleteprogram'])->name('deleteprogram');
Route::post('/obexmanagement/subprogram/{id}', [App\Http\Controllers\OBEXcontroller::class, 'deletesubprogram'])->name('deletesubprogram');
Route::post('/obexmanagement/obex/{id}', [App\Http\Controllers\OBEXcontroller::class, 'deleteobex'])->name('deleteobex');

