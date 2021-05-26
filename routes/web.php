<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\SubjectsController;
use App\Http\Controllers\AdminController;

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

Route::group(['middleware' => 'auth:admin', 'prefix' => '/admin'], function(){
    Route::get('/dashboard', [AdminController::class, 'index'])->name("admin.dashboard");

    Route::prefix('subjects')->group(function(){
        Route::get('/', [SubjectsController::class, 'index'])->name("admin.subjects");
        Route::post('/', [SubjectsController::class, 'get'])->name("admin.getsubjects");
        Route::post('/add', [SubjectsController::class, 'create'])->name("admin.addsubject");
        Route::post('/delete', [SubjectsController::class, 'delete'])->name("admin.deletesubject");
        Route::post('/update', [SubjectsController::class, 'update'])->name("admin.updatesubject");
    });

});
Route::get("/", function () {
    return view('main');
});
Route::get("/login", function(){
    return view('main');
});


Route::prefix('/adminlogin')->group(function(){
    Route::get("/", [AdminLoginController::class, 'index']);
    Route::post("/", [AdminLoginController::class, 'dologin'])->name("admin.login");
});
