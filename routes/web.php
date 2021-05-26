<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\SubjectsController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\CourseController;
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
    Route::prefix('departments')->group(function(){
        Route::get('/', [DepartmentController::class, 'index'])->name("admin.departments");
        Route::post('/', [DepartmentController::class, 'get'])->name("admin.getdepartments");
        Route::post('/add', [DepartmentController::class, 'create'])->name("admin.adddepartment");
        Route::post('/delete', [DepartmentController::class, 'delete'])->name("admin.deletedepartment");
        Route::post('/update', [DepartmentController::class, 'update'])->name("admin.updatedepartment");
    });
    Route::prefix('courses')->group(function(){
        Route::get('/', [CourseController::class, 'index'])->name("admin.courses");
        Route::post('/', [CourseController::class, 'get'])->name("admin.getcourses");
        Route::get('/getdepartments', [CourseController::class, 'search'])->name("admin.courses.getdepartments");
        Route::post('/add', [CourseController::class, 'create'])->name("admin.addcourse");
        Route::post('/delete', [CourseController::class, 'delete'])->name("admin.deletecourse");
        Route::post('/update', [CourseController::class, 'update'])->name("admin.updatecourse");
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
