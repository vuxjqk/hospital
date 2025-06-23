<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ServiceRequestController;
use App\Http\Controllers\ServiceRequestDetailController;
use App\Http\Controllers\SpecialtyController;
use App\Models\ServiceRequest;
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
        Route::resource('patients', PatientController::class);
        Route::resource('medical_records', MedicalRecordController::class);
        Route::resource('appointments', AppointmentController::class);
        Route::resource('doctors', DoctorController::class);
        Route::resource('specialties', SpecialtyController::class);
        Route::resource('services', ServiceController::class);
        Route::get('/service_requests/create/{appointment_id}', [ServiceRequestController::class, 'create'])->name('service_requests.create');
        Route::post('/service_requests', [ServiceRequestController::class, 'store'])->name('service-requests.store');
        Route::get('/service-request-details', [ServiceRequestDetailController::class, 'index'])
            ->name('service-request-details.index');

        Route::post('/service-request-details', [ServiceRequestDetailController::class, 'store'])
            ->name('service-request-details.store');

        Route::get('/service-request-details/{id}', [ServiceRequestDetailController::class, 'show'])
            ->name('service-request-details.show');
    });

    Route::middleware('can:is-doctor')->group(function () {
        //
    });

    Route::middleware('can:is-receptionist')->group(function () {
        //
    });

    Route::middleware('can:is-cashier')->group(function () {
        //
    });

    Route::middleware('can:is-service-staff')->group(function () {
        //
    });

    Route::middleware('can:is-pharmacist')->group(function () {
        //
    });

    Route::middleware('can:is-inpatient-manager')->group(function () {
        //
    });

    Route::middleware('can:is-hr-manager')->group(function () {
        //
    });

    Route::middleware('can:is-patient')->group(function () {
        //
    });
});

require __DIR__ . '/auth.php';
