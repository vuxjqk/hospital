<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware('can:is-admin')->group(function () {
        //Route::get('/admin/dashboard', [AdminController::class, 'index']);
        Route::resource('medical_records', MedicalRecordController::class);
    });

    Route::middleware('can:is-doctor')->group(function () {
        Route::resource('patients', PatientController::class);
        Route::resource('medical_records', MedicalRecordController::class);
        Route::resource('appointments', AppointmentController::class);
    });

    Route::middleware('can:is-receptionist')->group(function () {
        //
    });

    Route::middleware('can:is-cashier')->group(function () {
        //Route::get('/cashier', [CashierController::class, 'index']);
    });

    Route::middleware('can:is-service-staff')->group(function () {
        //Route::get('/service', [ServiceController::class, 'index']);
    });

    Route::middleware('can:is-pharmacist')->group(function () {
        //Route::get('/pharmacy', [PharmacyController::class, 'index']);
    });

    Route::middleware('can:is-inpatient-manager')->group(function () {
        //Route::get('/inpatient', [InpatientController::class, 'index']);
    });

    Route::middleware('can:is-hr-manager')->group(function () {
        //Route::get('/hr', [HRController::class, 'index']);
    });

    Route::middleware('can:is-patient')->group(function () {
        //Route::get('/patient', [PatientController::class, 'profile']);
    });
});

require __DIR__ . '/auth.php';
