<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Http\Controllers\PixController;
use App\Http\Middleware\CheckApiKey;
use App\Http\Controllers\AccountController;

Route::get('/', function () {
    return view('welcome');
})->name('home');



Route::get('/pix', [PixController::class, 'index'])
    ->middleware(['auth', 'verified', CheckApiKey::class])
    ->name('pix');

Route::get('dashboard', [AccountController::class, 'dashboard'])
    ->middleware(['auth', 'verified', CheckApiKey::class])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__.'/auth.php';
