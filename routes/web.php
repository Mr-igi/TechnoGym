<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TrainerController;
use App\Http\Controllers\TrainingSessionController;
use App\Http\Controllers\GroupClassInquiryController;
use App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\GroupClassController;
use App\Http\Controllers\Admin\MembershipPlanController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/o-nama', [HomeController::class, 'about'])->name('about');
Route::post('/kontakt', [HomeController::class, 'contact'])->name('contact');

Route::get('/clanarine', [MembershipController::class, 'index'])->name('memberships.index');
Route::get('/treneri', [TrainerController::class, 'index'])->name('trainers.index');
Route::get('/treneri/{trainer}', [TrainerController::class, 'show'])->name('trainers.show');
Route::get('/treneri/{trainer}/dostupnost', [TrainingSessionController::class, 'availability'])->name('sessions.availability');
Route::get('/grupni-treninzi/{groupClass}/prijava', [GroupClassInquiryController::class, 'show'])->name('group-classes.inquiry');
Route::post('/grupni-treninzi/{groupClass}/prijava', [GroupClassInquiryController::class, 'store'])->name('group-classes.inquiry.store');

Route::middleware('guest')->group(function () {
    Route::get('/prijava', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/prijava', [AuthController::class, 'login']);
    Route::get('/registracija', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/registracija', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::post('/odjava', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/clanarina/{plan}/kupovina', [MembershipController::class, 'checkout'])->name('membership.checkout');
    Route::post('/clanarina/kupovina', [MembershipController::class, 'purchase'])->name('membership.purchase');
    Route::post('/treninzi/zakazi', [TrainingSessionController::class, 'store'])->name('sessions.store');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [Admin\DashboardController::class, 'index'])->name('dashboard');

    Route::resource('treneri', Admin\TrainerController::class)
        ->parameters(['treneri' => 'trainer'])
        ->names([
            'index'   => 'trainers.index',
            'create'  => 'trainers.create',
            'store'   => 'trainers.store',
            'edit'    => 'trainers.edit',
            'update'  => 'trainers.update',
            'destroy' => 'trainers.destroy',
        ]);

    Route::get('zakazivanja', [Admin\SessionController::class, 'index'])->name('sessions.index');
    Route::patch('zakazivanja/{session}/status', [Admin\SessionController::class, 'updateStatus'])->name('sessions.status');

    Route::get('korisnici', [Admin\UserController::class, 'index'])->name('users.index');

    Route::resource('clanarine', MembershipPlanController::class)
        ->parameters(['clanarine' => 'membership'])
        ->names([
            'index'   => 'memberships.index',
            'create'  => 'memberships.create',
            'store'   => 'memberships.store',
            'edit'    => 'memberships.edit',
            'update'  => 'memberships.update',
            'destroy' => 'memberships.destroy',
        ]);

    Route::post('treneri/{trainer}/grupni-treninzi', [GroupClassController::class, 'store'])
        ->name('group-classes.store');
    Route::delete('treneri/{trainer}/grupni-treninzi/{groupClass}', [GroupClassController::class, 'destroy'])
        ->name('group-classes.destroy');
});
