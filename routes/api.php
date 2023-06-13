<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\PostsController;
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



// Route Post
Route::get('/posts',[PostsController::class, 'index']);
Route::get('/posts/{id}',[PostsController::class, 'show']);
Route::post('/posts', [PostsController::class, 'store']);
Route::patch('/posts/{id}', [PostsController::class, 'update']);
Route::delete('/posts/{id}', [PostsController::class, 'delete']);


// Route Login
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout']);
Route::post('/register', [AuthController::class, 'register']);
Route::get('/me', [AuthController::class, 'me']);

// Route Comment

Route::post('/comment', [CommentsController::class, 'store']);
Route::delete('/comment/{id}', [CommentsController::class, 'delete']);
Route::patch('/comment/{id}', [CommentsController::class, 'update']);