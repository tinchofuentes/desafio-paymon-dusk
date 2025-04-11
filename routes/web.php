<?php

use App\Livewire\Pages\Enrollments\CreateEnrollmentComponent;
use App\Livewire\Pages\AcademicOfferComponent;
use App\Livewire\Admin\Communications\ManageCommunicationsComponent;
use App\Mail\CommunicationMail;
use App\Models\Communication;
use App\Models\Enrollment;
use App\Models\Guardian;
use Illuminate\Support\Facades\Route;

Route::get('/', AcademicOfferComponent::class)->name('home');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::get('/enrollments/create/{course}', CreateEnrollmentComponent::class)->name('enrollment.create');

Route::get('/enrollments/{enrollment}/confirmation', function($enrollment) {
    return view('enrollments.confirmation', ['enrollment' => Enrollment::findOrFail($enrollment)]);
})->name('enrollment.confirmation');

// Rutas de administración
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/communications', ManageCommunicationsComponent::class)->name('admin.communications');
});

// Ruta para previsualización de correos (solo en entorno local)
if (app()->environment('local')) {
    Route::get('/mailable/communication/{id}', function ($id) {
        $communication = Communication::findOrFail($id);
        $guardian = Guardian::first() ?? Guardian::factory()->create([
            'name' => 'Guardian de Prueba',
            'email' => 'guardian@example.com',
            'phone' => '123456789'
        ]);
        
        return new CommunicationMail($communication, $guardian);
    });
}

require __DIR__ . '/auth.php';
