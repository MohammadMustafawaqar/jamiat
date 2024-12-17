<?php

use App\Http\Controllers\Jamiat\CampusController;
use App\Http\Controllers\Jamiat\ClassController;
use App\Http\Controllers\Jamiat\EducationLevelController;
use App\Http\Controllers\Jamiat\ExamController;
use App\Http\Controllers\Jamiat\FormController;
use App\Http\Controllers\Jamiat\Forms\CommissionController;
use App\Http\Controllers\Jamiat\Forms\EvaluationController;
use App\Http\Controllers\Jamiat\Forms\RajabController;
use App\Http\Controllers\Jamiat\GradeController;
use App\Http\Controllers\Jamiat\LanguageController;
use App\Http\Controllers\Jamiat\StudentScoreController;
use App\Http\Controllers\Jamiat\SubClassController;
use App\Http\Controllers\Jamiat\SubjectController;
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

        // Subjects
        Route::resource('subjects', SubjectController::class);
    });

    Route::resource('exam', ExamController::class);
    Route::post('exam/subject/{exam_id}', [ExamController::class, 'assignSubjects'])
        ->name('exam.subjects');

    Route::get('/exam/get-exam-subjects/{exam_id}', [ExamController::class, 'getExamSubjects'])
        ->name('exam.get.subjects');

    Route::group([
        'as' => 'student.',
        'prefix' => 'student/',
        'controller' => StudentController::class
    ], function () {
        Route::get('second-form', 'secondForm')
            ->name('form.second')
            ->middleware('permission:students.create');

        Route::get('{student}', 'showEmployee')
            ->name('show');

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

        Route::get('/evaluation/export', 'evaluationStudentExport')
            ->name('evaluation.export');


        // Generate Card

        Route::post('/generate-card', 'generateIdCard')
            ->name('generate.card');

        // Student Exam Scores
        Route::group([
            'as' => 'scores.',
            'prefix' => '/scores/',
            'controller' => StudentScoreController::class
        ], function () {
            Route::get('create/many', 'createMany')
                ->name('many.create');

            Route::post('exam/{exam_id}/store/many', 'storeMany')
                ->name('many.store');
        });
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

    Route::group([
        'as' => 'forms.',
        'prefix' => 'forms/',
        'controller' => FormController::class
    ], function () {

        Route::get('commission/print-many', [CommissionController::class, 'printManyForms'])
            ->name('commission.print.many');
        Route::resource('/commission', CommissionController::class);
        Route::get('rajab/print-many', [RajabController::class, 'printManyForms'])
            ->name('rajab.print.many');
        Route::resource('/rajab', RajabController::class);

        Route::get('evaluation/print-many', [EvaluationController::class, 'printManyForms'])
            ->name('evaluation.print.many');
        Route::resource('/evaluation', EvaluationController::class);
        // Route::group([
        //     'as' => 'commission.',
        //     'prefix' => 'commission/',
        // ], function(){
        //     R
        // });
    });
});
