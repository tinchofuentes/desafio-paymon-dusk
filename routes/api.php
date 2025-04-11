<?php

use App\Http\Controllers\Api\AcademyController;
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
    Route::apiResource('academies', AcademyController::class)->only(['index', 'show']);
    
    Route::apiResource('courses', CourseController::class)->only(['index', 'show']);
    
    Route::apiResource('enrollments', EnrollmentController::class)->only(['store']);
});

Route::middleware('auth:sanctum')->prefix('v1')->group(function () {
    Route::apiResource('academies', AcademyController::class)->except(['index', 'show']);
    
    Route::apiResource('courses', CourseController::class)->except(['index', 'show']);
    
    Route::apiResource('enrollments', EnrollmentController::class)->except(['store']);
    
    Route::apiResource('communications', CommunicationController::class);
    
    Route::post('communications/{communication}/send', [CommunicationController::class, 'send'])
        ->name('communications.send');
    
    Route::post('payments/{payment}/process', [PaymentController::class, 'process'])
        ->name('payments.process');
});
