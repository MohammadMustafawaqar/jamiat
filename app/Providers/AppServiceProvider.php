<?php

namespace App\Providers;

use App\Models\School;
use App\Models\Student;
use App\Models\Supervisor;
use App\Models\SupervisorStudent;
use App\Observers\UserActionObserver;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        School::observe(UserActionObserver::class);
        Student::observe(UserActionObserver::class);
        Supervisor::observe(UserActionObserver::class);
        SupervisorStudent::observe(UserActionObserver::class);

        Paginator::useBootstrapFive();


        Blade::component('components.backend.shared.btn.add', 'btn-add');
        Blade::component('components.backend.shared.btn.edit', 'btn-edit');
        Blade::component('components.backend.shared.btn.back', 'btn-back');
        Blade::component('components.backend.shared.btn.delete', 'btn-delete');
        Blade::component('components.backend.shared.btn.save', 'btn-save');
        Blade::component('components.backend.shared.btn.search', 'btn-search');
        Blade::component('components.backend.shared.btn.update', 'btn-update');

        Blade::component('components.backend.shared.btn.next', 'btn-next');
        Blade::component('components.backend.shared.btn.previous', 'btn-prev');
        Blade::component('components.backend.shared.btn.filter', 'btn-filter');
        Blade::component('components.backend.shared.btn.print-button', 'btn-print');
        Blade::component('components.backend.shared.btn.cancel', 'btn-cancel');
        Blade::component('components.backend.shared.btn.reset', 'btn-reset');

        Blade::component('components.backend.shared.checkbox', 'checkbox');
        Blade::component('components.backend.shared.editor', 'editor');
        Blade::component('components.backend.shared.modal', 'model');
        Blade::component('components.backend.shared.radio', 'radio');
        Blade::component('components.backend.shared.textarea', 'textarea');
        Blade::component('components.backend.shared.input', 'input');
        Blade::component('components.backend.shared.loader', 'loader');
        Blade::component('components.backend.shared.select',  'select-btn');
        Blade::component('components.backend.shared.simple-select', 'simple-select');
        Blade::component('components.backend.shared.select2', 'select2');
        Blade::component('components.backend.shared.js-select2', 'js-select2');
        Blade::component('components.backend.shared.date-picker', 'date-picker');
        Blade::component('components.backend.shared.file', 'file');

        Blade::component('components.backend.shared.input2', 'input2');
        Blade::component('components.backend.shared.btn.delete2', 'btn-delete2');
        Blade::component('components.backend.shared.btn.filter2', 'btn-filter2');

        // Layout
        Blade::component('components.backend.shared.layout.main', 'app');
        Blade::component('components.backend.shared.layout.guest', 'guest');
        Blade::component('components.backend.shared.page-container', 'page-container');
        Blade::component('components.backend.shared.page-nav', 'page-nav');
        Blade::component('components.backend.shared.table', 'table');

        // Qamari Date
        Blade::component('components.backend.shared.qamari-input', 'qamari-input');

    }
}
