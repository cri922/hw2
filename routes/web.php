<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomAuthenticationController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\DatabaseApiController;

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

Route::get('/', [PagesController::class,'index'])->name('index');

Route::get('/login',[CustomAuthenticationController::class,'loginForm'])->name('login_form');
Route::post('/login',[CustomAuthenticationController::class,'doLogin'])->name('do_login');
Route::get('/signup',[CustomAuthenticationController::class,'signupForm'])->name('signup_form');
Route::post('/signup',[CustomAuthenticationController::class,'doSignup'])->name('do_signup');
Route::get('/logout',[CustomAuthenticationController::class,'logout'])->name('logout');

Route::get('/home',[PagesController::class,'home'])->name('home');

Route::get('/profile',[PagesController::class,'profile'])->name('profile');

Route::get('/anime/{id}',[PagesController::class,'anime'])->where('id','[0-9]+')->name('anime');

Route::get('/delete/account',[PagesController::class,'deleteAccount'])->name('delete');


//example to search if an username is alreay used or not
//search?q=franco_lo
Route::get('/check/username',[DatabaseApiController::class,'checkUsername']);

//example to search if an email is alreay used or not
//search?q=franco@gmail.com
Route::get('/check/email',[DatabaseApiController::class,'checkEmail']);

//get likes
Route::get('/get/likes',[DatabaseApiController::class,'getLikes']);

//add like
Route::get('/like/add/{id}',[DatabaseApiController::class,'addLike'])->where('id','[0-9]+');
//remove like
Route::get('/like/remove/{id}',[DatabaseApiController::class,'removeLike'])->where('id','[0-9]+');

//get comments for a specific animeid
Route::get('/get/comments/{id}',[DatabaseApiController::class,'getComments'])->where('id','[0-9]+');

//add comment
Route::post('/comment/add/{id}',[DatabaseApiController::class,'addComment'])->where('id','[0-9]+');

