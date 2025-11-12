<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\ExamController as AdminExamController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\User\ExamController as UserExamController;
use App\Http\Controllers\User\ResultController;

Route::get('/', function () {
    return redirect()->route('login');
});

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // Exam Management
    Route::resource('exams', AdminExamController::class);
    
    // Question Management 
    Route::prefix('exams/{exam}/questions')->name('questions.')->group(function () {
        Route::get('/', [QuestionController::class, 'index'])->name('index');
        Route::get('/create', [QuestionController::class, 'create'])->name('create');
        Route::post('/', [QuestionController::class, 'store'])->name('store');
        Route::get('/{question}/edit', [QuestionController::class, 'edit'])->name('edit');
        Route::put('/{question}', [QuestionController::class, 'update'])->name('update');
        Route::delete('/{question}', [QuestionController::class, 'destroy'])->name('destroy');
    });

    // Category Management
    Route::resource('categories', CategoryController::class)->except(['show']);

    // Reports
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('index');
        Route::get('/exam/{exam}', [ReportController::class, 'examStatistics'])->name('exam');
    });
});

// User Routes
Route::middleware(['auth', 'user'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', function () {
        return view('user.dashboard');
    })->name('dashboard');

    // Exam Routes
    Route::prefix('exams')->name('exams.')->group(function () {
        Route::get('/', [UserExamController::class, 'index'])->name('index');
        Route::get('/{exam}', [UserExamController::class, 'show'])->name('show');
        Route::post('/{exam}/start', [UserExamController::class, 'start'])->name('start');
        Route::get('/attempt/{attempt}', [UserExamController::class, 'take'])->name('take');
        Route::post('/attempt/{attempt}', [UserExamController::class, 'submit'])->name('submit');
    });

    // Results Routes
    Route::prefix('results')->name('results.')->group(function () {
        Route::get('/', [ResultController::class, 'index'])->name('index');
        Route::get('/{attempt}', [ResultController::class, 'show'])->name('show');
    });
});