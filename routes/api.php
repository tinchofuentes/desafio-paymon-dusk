<?php

use App\Http\Controllers\Api\AcademyController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\EnrollmentController;
use App\Http\Controllers\Api\CommunicationController;
use App\Http\Controllers\Api\PaymentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('v1')->group(function () {
    Route::post('auth/login', [AuthController::class, 'login'])->name('auth.login');
    
    // Public routes
    Route::apiResource('academies', AcademyController::class)->only(['index', 'show']);
    
    Route::apiResource('courses', CourseController::class)->only(['index', 'show']);
    
    Route::apiResource('enrollments', EnrollmentController::class)->only(['store']);
});

Route::middleware('auth:sanctum')->prefix('v1')->group(function () {
    Route::post('auth/logout', [AuthController::class, 'logout'])->name('auth.logout');
    Route::get('auth/user', [AuthController::class, 'user'])->name('auth.user');
    
    Route::apiResource('academies', AcademyController::class)->except(['index', 'show']);
    
    Route::apiResource('courses', CourseController::class)->except(['index', 'show']);
    
    Route::apiResource('enrollments', EnrollmentController::class)->except(['store']);
    
    Route::apiResource('communications', CommunicationController::class);
    
    Route::post('communications/{communication}/send', [CommunicationController::class, 'send'])
        ->name('communications.send');
    
    // Ruta para registrar pagos
    Route::post('payments', [PaymentController::class, 'store'])
        ->name('payments.store');
});
