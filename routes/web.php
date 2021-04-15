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

Route::get('/', HomeController::class)->name("home");

Route::get('consult/insert', [ConsultsController::class, 'create'])->name("consult.create");
Route::get('consult/{id}', [ConsultsController::class, 'show'])->name("consult.show");
Route::get('consults', [ConsultsController::class, 'index'])->name("consults");
Route::get('consult/{id}/update', [ConsultsController::class, 'edit'])->name("consult.edit");

Route::post('consult/insert', [ConsultsController::class, 'insert'])->name("consult.insert");
Route::put('consult/{id}', [ConsultsController::class, 'update'])->name("consult.update");

Route::get('consult/{id}/delete', [ConsultsController::class, 'modal'])->name("consult.modal");
Route::delete('consult/{id}', [ConsultsController::class, 'delete'])->name("consult.delete");
Route::post('consults', [UsersController::class, 'login'])->name("user.login");

Route::get('/', [UsersController::class, 'logout'])->name("user.logout");
