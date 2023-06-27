<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TodoController;
use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// Route Auth
Route::controller(AuthController::class)->group(function(){
    Route::post('login','login');
    Route::post('register','register');
});

// For Todo
Route::post('store_todo',[TodoController::class, 'store']);
Route::get('show_todo', [TodoController::class, 'index']);
Route::post('delete_todo', [TodoController::class, 'delete']);
Route::post('mask_as_todo', [TodoController::class, 'maskAs']);
Route::post('mask_down_todo', [TodoController::class, 'maskDown']);
Route::get('edit_todo', [TodoController::class, 'editTodo']);
