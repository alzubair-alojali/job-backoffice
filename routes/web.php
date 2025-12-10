<?php

use App\Http\Controllers\Dashboard;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\JobCategoryController;
use App\Http\Controllers\JobVacancyController;
use App\Http\Controllers\ResumeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;



//shared routes
Route::middleware('auth', 'role:admin,company-owner')->group(function () {
    Route::get('/', [dashboardController::class, 'index'])->name('dashboard');

    // job-application
    Route::resource('job-application', JobApplicationController::class);
    Route::put('job-application/restore/{id}', [JobApplicationController::class, 'restore'])->name('job-application.restore');

    // job-vacancy
    Route::resource('job-vacancies', JobVacancyController::class);
    Route::put('job-vacancies/restore/{id}', [JobVacancyController::class, 'restore'])->name('job-vacancies.restore');
});

//company routes
Route::middleware('auth', 'role:company-owner')->group(function () {
    Route::get('/my-company', [CompanyController::class, 'show'])->name('my-company.show');
    Route::get('/my-company/edit', [CompanyController::class, 'edit'])->name('my-company.edit');
    Route::put('/my-company', [CompanyController::class, 'update'])->name('my-company.update');
});

//admin routes
Route::middleware('auth', 'role:admin')->group(function () {
    // company
    Route::resource('company', CompanyController::class);
    Route::put('company/restore/{id}', [CompanyController::class, 'restore'])->name('company.restore');

    // job-category
    Route::resource('job-categories', JobCategoryController::class);
    Route::put('job-categories/restore/{id}', [JobCategoryController::class, 'restore'])->name('job-categories.restore');

    // user
    Route::resource('users', UserController::class);
    Route::put('users/restore/{id}', [UserController::class, 'restore'])->name('users.restore');


});

require __DIR__ . '/auth.php';
