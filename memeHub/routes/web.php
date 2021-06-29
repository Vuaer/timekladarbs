<?php

use App\Http\Controllers\UploadController;
use App\Http\Controllers\CreateController;
use App\Http\Controllers\LibraryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MemeController;
use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OAuthController;


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
Route::middleware(['set_locale'])->group(function() 
{
    

Route::resource('meme', MemeController::class);
Route::get('/',[MemeController::class,'index']);
Route::get('/dashboard',[MemeController::class,'index'])->middleware(['auth'])->name('dashboard');
require __DIR__.'/auth.php';

Route::get('/login/google',[OAuthController::class,'redirectGoogle'])->name('login.google');
Route::get('/login/google/callback',[OAuthController::class,'handleGoogleCallback']);
Route::get('/login/facebook',[OAuthController::class,'redirectFacebook'])->name('login.facebook');
Route::get('/login/facebook/callback',[OAuthController::class,'handleFacebookCallback']);


Route::post('/meme',[MemeController::class,'upload']);
Route::get('/personalize',[MemeController::class,'personalize'])->name('personalize');
Route::delete('/meme/{id}',[MemeController::class,'destroy']);
Route::get('/search',[MemeController::class,'search'])->name("meme.search");



Route::get('/profile',[ProfileController::class,'index'])->name('profile.index');
Route::get('/findUser/{id}',[ProfileController::class,'findUser']);
Route::post('/changerole/{id}',[ProfileController::class,'changeRole']);
Route::get('/showBanUser/{id}',[ProfileController::class,'showBanUser']);
Route::post('/ban/{id}',[ProfileController::class,'ban']);

Route::resource('library',LibraryController::class);
Route::get('/profile/library',[LibraryController::class,'index']);
Route::delete('/profile/library/{id}',[LibraryController::class,'destroy']);
Route::get('/create',[CreateController::class,'index']);
Route::get('/profile/upload',[UploadController::class,'index']);
Route::put('profile/update',[ProfileController::class,'update'])->name('profile.update');
Route::get('/create/{id}',[CreateController::class,'create']);

Route::post('/create/meme',[CreateController::class,'upload'])->name("meme.create");

Route::get('/profile/mymemes',[LibraryController::class,'showmymemes']);

Route::get('/meme/{id}',[MemeController::class,'show']);
Route::resource('comment',CommentController::class);
Route::delete('/comment/{id}',[MemeController::class,'destroy']);

Route::post('meme/like',[MemeController::class,'like'])->name("meme.like");
Route::post('meme/dislike',[MemeController::class,'dislike'])->name("meme.dislike");
Route::get('meme/download/{id}',[MemeController::class,'download'])->name("meme.download");

Route::get('locale/{locale}',[ProfileController::class,'changeLocale'])->name('locale');

Route::get('/profile/delete/{keyword}',[ProfileController::class,'deleteKeyword']);


});
