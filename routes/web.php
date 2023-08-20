<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PageController;
use App\Http\Middleware\Cors;

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

//Generate the token
Route::get('/token', function () { return csrf_token(); })->middleware(Cors::class);

//Get All pages
Route::get('/pages', [PageController::class, 'getPages'])->middleware(Cors::class);

//Get page by id
Route::get('/pages/{id}', [PageController::class, 'show'])->middleware(Cors::class);

//Get page by link
Route::get('/content', [PageController::class, 'getContentByLink'])->middleware(Cors::class);

//Add new page
Route::post('/pages', [PageController::class, 'store'])->middleware(Cors::class);

//update page by id 
Route::put('/pages/{id}', [PageController::class, 'update'])->middleware(Cors::class);

//delete a page by id
Route::delete('/pages/{id}', [PageController::class, 'destroy'])->middleware(Cors::class);