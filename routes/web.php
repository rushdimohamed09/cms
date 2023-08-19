<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PageController;

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
Route::get('/token', function () { return csrf_token(); });

//Get All pages
Route::get('/pages', [PageController::class, 'index']);

//Get page by id
Route::get('/pages/{id}', [PageController::class, 'show']);

//Add new page
Route::post('/pages', [PageController::class, 'store']);

//update page by id 
Route::put('/pages/{id}', [PageController::class, 'update']);

//delete a page by id
Route::delete('/pages/{id}', [PageController::class, 'destroy']);