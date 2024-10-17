<?php

use App\Http\Controllers\AjaxController;
use App\Http\Controllers\AppreciationController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CommitteeMemberController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\DistrictController;
use App\Http\Controllers\FeeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProvinceController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\SupervisorController;
use App\Http\Controllers\SupervisorStudentController;
use App\Http\Controllers\ThesisController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\UserController;
use App\Models\CommitteeMember;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});
Route::redirect('/home', '/ps/home');

// Auth::routes(['register' => false]);
Auth::routes();

Route::get('change-language/{lang}', function ($lang) {
    // Get the previous route URL
    $previousRoute = url()->previous();
    // Parse the previous route URL to extract the current language
    $previousRouteSegments = explode('/', $previousRoute);
    $currentLang = $previousRouteSegments[3];
    // Replace the language parameter in the previous route URL
    $redirectUrl = str_replace("/$currentLang", "/$lang", $previousRoute);
    // Redirect to the previous route with the specified language parameter
    return redirect($redirectUrl);
})->name('change-language');

Route::prefix('{locale}')->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::group(['middleware' => ['admin']], function () {
        Route::resource('schools', SchoolController::class);
        Route::resource('students', StudentController::class);
        Route::resource('supervisors', SupervisorController::class);
        Route::resource('supervisor-student', SupervisorStudentController::class);
        Route::resource('fee', FeeController::class);
        Route::group(['prefix' => '/settings'], function () {
            Route::resource('country', CountryController::class);
            Route::resource('province', ProvinceController::class);
            Route::resource('district', DistrictController::class);
            Route::resource('category', CategoryController::class);
            Route::resource('sub-category', SubCategoryController::class);
            Route::resource('appreciation', AppreciationController::class);
            Route::resource('committee-member', CommitteeMemberController::class);
        });

        Route::resource('user', UserController::class);
        Route::get('/logs/data', [UserController::class, 'getLogs'])->name('users.logs');


        Route::get('update-user-status', [UserController::class, 'updateUserStatus'])->name('user.update-user-status');
        Route::get('/backup-database', [HomeController::class, 'takeBackup'])->name('backup.database');
        Route::get('/backup/download', [HomeController::class, 'downloadStorageBackup'])->name('backup.download');
        Route::post('role', [RoleController::class, 'store'])->name('role.store');
        Route::get('role/{id}/edit', [RoleController::class, 'edit'])->name('role.edit');
        Route::put('role/{id}', [RoleController::class, 'update'])->name('role.update');
        Route::get('get-permissions', [RoleController::class, 'getPermissions'])->name('role.get-permissions');
        Route::post('give-permissions', [RoleController::class, 'givePermissions'])->name('role.give-permissions');
        Route::post('give-role', [RoleController::class, 'giveRole'])->name('user.give-role');
    });

    Route::group(['middleware' => ['supervisor']], function () {
        Route::get('/all-students', [SupervisorController::class, 'allStudent'])->name('all-students');
        Route::get('supervisor/student/{student_id}', [SupervisorController::class, 'showSupervisorStudent'])
            ->name('supervisor.student.show');
        Route::get('supervisor/student/thesis/{thesis_id}', [ThesisController::class, 'showSupervisorThesis'])
            ->name('supervisor.student.thesis.show');
        Route::put('supervisor/thesis/{thesis_id}', [ThesisController::class, 'updataStatus'])
            ->name('supervisor.thesis.update');
    });
    
    Route::view('change-password', 'user.changePassword')->name('user.setting');
    Route::post('user/change-password', [UserController::class, 'changePassword'])->name('user.change-password');
    Route::resource('topic', TopicController::class);
    Route::resource('comment', CommentController::class);

    Route::group(['middleware' => ['student']], function () {
        // Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
        Route::resource('thesis', ThesisController::class);
        Route::get('search-topic', [TopicController::class, 'searchTopic'])->name('topic.search');
        Route::view('user-profile', 'studentPages.profile')->name('student.profile');
        Route::put('student-profile-update/{id}', [StudentController::class, 'updateProfile'])->name('students.prifle.update');
    });
    Route::get('load-provinces', [AjaxController::class, 'loadProvinces'])->name('load-provinces');
    Route::get('load-districts', [AjaxController::class, 'loadDistricts'])->name('load-districts');
    Route::get('load-sub-categories', [AjaxController::class, 'loadSubCategories'])->name('load-sub-categories');
});
