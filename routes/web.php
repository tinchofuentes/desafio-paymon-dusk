<?php

use App\Livewire\Pages\Enrollments\CreateEnrollmentComponent;
use App\Livewire\Pages\AcademicOfferComponent;
use App\Models\Enrollment;
use Illuminate\Support\Facades\Route;

Route::get('/', AcademicOfferComponent::class)->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::get('/enrollments/create/{course}', CreateEnrollmentComponent::class)->name('enrollment.create');

Route::get('/enrollments/{enrollment}/confirmation', function($enrollment) {
    return view('enrollments.confirmation', ['enrollment' => Enrollment::findOrFail($enrollment)]);
})->name('enrollment.confirmation');

require __DIR__ . '/auth.php';
