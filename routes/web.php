<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{ HomeController, ConsultsController, LoginController, UserController };


Route::group(['middleware' => ['web']], function() {

    Route::get('/', HomeController::class)->name("home.get");
    Route::get('logout/user', [LoginController::class, 'logout'])->name("user.get.logout");
    Route::post('login/user', [LoginController::class, 'authenticate'])->name("user.post.login");
    Route::get('new/user', [UserController::class, 'insertView'])->name("user.get.new");
    Route::post('new/user', [UserController::class, 'insert'])->name("user.post.new");

});

Route::group(['middleware' => ['auth']], function() {

    Route::get('new/consult', [ConsultsController::class, 'insertView'])->name("consult.get.new");
    Route::get('view/consults', [ConsultsController::class, 'index'])->name("consults.get.view");
    Route::get('view/consult/{id}', [ConsultsController::class, 'show'])->name("consult.get.view");
    Route::post('new/consult', [ConsultsController::class, 'insert'])->name("consult.post.new");

    Route::get('edit/consult/{id}', [ConsultsController::class, 'updateView'])->name("consult.get.edit");
    Route::put('edit/consult/{id}', [ConsultsController::class, 'update'])->name("consult.put.edit");

    Route::get('delete/consult/{id}', [ConsultsController::class, 'deleteView'])->name("consult.get.delete");
    Route::delete('delete/consult/{id}', [ConsultsController::class, 'delete'])->name("consult.delete.delete");

});

