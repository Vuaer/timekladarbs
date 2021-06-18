<?php

use App\Http\Controllers\UploadController;
use App\Http\Controllers\CreateController;
use App\Http\Controllers\LibraryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MemeController;
use Illuminate\Support\Facades\Route;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::resource('meme', MemeController::class);
Route::get('/',[MemeController::class,'index']);
Route::get('/dashboard',[MemeController::class,'index'])->middleware(['auth'])->name('dashboard');
require __DIR__.'/auth.php';


Route::post('/meme',[MemeController::class,'upload']);
Route::delete('/meme/{id}',[MemeController::class,'destroy']);
HEAD



Route::get('/profile',[ProfileController::class,'index']);
Route::get('/profile/library',[LibraryController::class,'index']);
Route::get('/create',[CreateController::class,'index']);
Route::get('/profile/upload',[UploadController::class,'index']);



Route::post('meme/like',[MemeController::class,'like'])->name("meme.like");
Route::post('meme/dislike',[MemeController::class,'dislike'])->name("meme.dislike");
stefan_database_patch1
