<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail; // Add this line

use App\Http\Controllers\Auth\AuthenticatedSessionController;

Route::get('/', [AuthenticatedSessionController::class, 'create'])
    ->middleware('guest')
    ->name('login'); // This allows the root `/` to show the login form


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/test-email', function () {
    Mail::raw('This is a test email sent using MailHog.', function ($message) {
        $message->to('test@example.com')
            ->subject('MailHog Test Email');
    });

    return 'Email sent!';
});

require __DIR__ . '/auth.php';
