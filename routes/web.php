<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ConsultsController;
use App\Http\Controllers\UsersController;

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

Route::group(['middleware' => ['web']], function() {

    Route::get('/', HomeController::class)->name("user.get.login");
    Route::get('logout', [UsersController::class, 'logout'])->name("user.get.logout");
    Route::post('login', [UsersController::class, 'login'])->name("user.post.login");

});

// Route::group(['middleware' => ['web']], function() {});
// não está funcionando

Route::get('consult/insert', [ConsultsController::class, 'insertView'])->name("consult.get.insert");
Route::get('consults', [ConsultsController::class, 'index'])->name("consults.get.index");
Route::get('consult/{id}/show', [ConsultsController::class, 'show'])->name("consult.get.show");
Route::post('consult/insert', [ConsultsController::class, 'insert'])->name("consult.post.insert");
        
Route::get('consult/{id}/update', [ConsultsController::class, 'updateView'])->name("consult.get.update");
Route::put('consult/{id}/update', [ConsultsController::class, 'update'])->name("consult.put.update");
        
Route::get('consult/{id}/remove', [ConsultsController::class, 'deleteView'])->name("consult.get.remove");
Route::delete('consult/{id}/remove', [ConsultsController::class, 'delete'])->name("consult.delete.remove");

