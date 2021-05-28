<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\SubjectsController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProspectusController;
use App\Http\Controllers\DeanLoginController;
use App\Http\Controllers\DeanController;
use App\Http\Controllers\StudentsController;
use App\Http\Controllers\LoadSubjectController;

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
        Route::get('/subjects', [SubjectsController::class, 'get_subjects'])->name("admin.subjects.getsubjects");
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
        Route::get('/getdepartments', [CourseController::class, 'get_departments'])->name("admin.courses.getdepartments");
        Route::post('/add', [CourseController::class, 'create'])->name("admin.addcourse");
        Route::post('/delete', [CourseController::class, 'delete'])->name("admin.deletecourse");
        Route::post('/update', [CourseController::class, 'update'])->name("admin.updatecourse");
    });
    Route::prefix('prospectus')->group(function(){
        Route::get('/', [ProspectusController::class, 'index'])->name("admin.prospectus");
        Route::post('/', [ProspectusController::class, 'get'])->name("admin.getprospectus");
        Route::get('/getsubjects', [ProspectusController::class, 'get_subjects'])->name("admin.prospectus.getsubjects");
        Route::post('/getcourses', [ProspectusController::class, 'get_courses'])->name("admin.prospectus.getcourses");
        Route::post('/add', [ProspectusController::class, 'create'])->name("admin.addprospectus");
        Route::post('/delete', [ProspectusController::class, 'delete'])->name("admin.deleteprospectus");
        Route::post('/update', [ProspectusController::class, 'update'])->name("admin.updateprospectus");
    });

    Route::prefix('deans')->group(function(){
        Route::get('/', [DeanController::class, 'index'])->name("admin.deans");
        Route::post('/', [DeanController::class, 'get'])->name("admin.getdeans");
        Route::post('/add', [DeanController::class, 'create'])->name("admin.adddean");
        Route::post('/delete', [DeanController::class, 'delete'])->name("admin.deletedean");
        Route::post('/update', [DeanController::class, 'update'])->name("admin.updatedean");
    });
    Route::prefix('students')->group(function(){
        Route::get('/', [StudentsController::class, 'index'])->name("admin.students");
        Route::post('/', [StudentsController::class, 'get'])->name("admin.getstudents");
        Route::post('/add', [StudentsController::class, 'create'])->name("admin.addstudent");
        Route::post('/delete', [StudentsController::class, 'delete'])->name("admin.deletestudent");
        Route::post('/update', [StudentsController::class, 'update'])->name("admin.updatestudent");
    });

});


Route::group(['middleware' => 'auth:dean', 'prefix' => '/dean'], function(){
    Route::get('/dashboard', [DeanController::class, 'index'])->name("dean.dashboard");
    Route::prefix('loadsubjects')->group(function(){
        Route::get('/', [LoadSubjectController::class, 'index'])->name("dean.loadsubjects");
        Route::post('/', [LoadSubjectController::class, 'get'])->name("dean.getloadsubjects");
        Route::post('/getsubjects', [LoadSubjectController::class, 'get_subjects'])->name("dean.loadsubjects.getsubjects");
        Route::post('/getstudents', [LoadSubjectController::class, 'get_students'])->name("dean.loadsubjects.getstudents");
        Route::post('/add', [LoadSubjectController::class, 'create'])->name("dean.addloadsubjects");
        Route::post('/delete', [LoadSubjectController::class, 'delete'])->name("dean.deleteloadsubjects");
        Route::post('/update', [LoadSubjectController::class, 'update'])->name("dean.updateloadsubjects");
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

Route::prefix('/deanlogin')->group(function(){
    Route::get("/", [DeanLoginController::class, 'index']);
    Route::post("/", [DeanLoginController::class, 'dologin'])->name("dean.login");
});