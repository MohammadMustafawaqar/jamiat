<?php

use App\Http\Controllers\Jamiat\CampusController;
use App\Http\Controllers\Jamiat\ClassController;
use App\Http\Controllers\Jamiat\EducationLevelController;
use App\Http\Controllers\Jamiat\ExamController;
use App\Http\Controllers\Jamiat\GradeController;
use App\Http\Controllers\Jamiat\LanguageController;
use App\Http\Controllers\Jamiat\SubClassController;
use App\Http\Controllers\Jamiat\UserGroupController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::group([
    'as' => 'admin.',
    'prefix' => 'admin/'
], function () {

    Route::group([
        'as' => 'settings.',
        'prefix' => 'settings/'
    ], function () {

        Route::resource('jamiat_grades', GradeController::class);
        Route::resource('education-level', EducationLevelController::class);
        Route::resource('languages', LanguageController::class);
        Route::resource('user-group', UserGroupController::class);

        Route::resource('campus', CampusController::class);
        Route::resource('/campus/{campus_id}/classes', ClassController::class);
        Route::resource('campus/classes/{class_id}/sub-classes', SubClassController::class);
    });

    Route::resource('exam', ExamController::class);

    Route::group([
        'as' => 'student.',
        'prefix' => 'student/',
        'controller' => StudentController::class
    ], function () {
        Route::get('second-form', 'secondForm')
            ->name('form.second')
            ->middleware('permission:students.create');

        Route::get('/form/rajab', 'rajabIndex')
            ->name('form.rajab')
            ->middleware('permission:students.read.rajab');

        Route::get('/form/commission', 'commissionForm')
            ->name('form.commission');

        Route::get('/form/evaluation', 'evaluationForm')
            ->name('form.evaluation');

        Route::post('import/form/excel/rajab', 'importRajabFromExcel')
            ->name('import.excel.rajab');

        Route::post('import/form/excel/', 'importFromExcel')
            ->name('import.excel');


        // Generate Card

        Route::post('/generate-card', 'generateIdCard')
            ->name('generate.card');
    });



    Route::group([
        'as' => 'school.',
        'prefix' => 'school/',
        'controller' => SchoolController::class,
    ], function () {
        Route::post('import/excel', 'importFromExcel')
            ->name('import.excel');

        Route::get('download/invalid-records/{file_name}', 'downloadInvalidFile')
            ->name('download.invalid.excel');
    });
});
