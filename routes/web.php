<?php

use App\Http\Controllers\ListingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicListingController;
use App\Http\Controllers\TeacherProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PublicListingController::class, 'landing'])->name('landing');

Route::get('/kursus', [PublicListingController::class, 'catalog'])->name('catalog');

Route::get('/kursus/{slug}/{region:slug}', [PublicListingController::class, 'show'])->name('listing.show');

Route::middleware('auth')->group(function () {
    Route::get('/teacher', fn() => view('teacher.dashboard'))->name('teacher.dashboard');
    Route::get('/teacher/profile', [TeacherProfileController::class, 'edit'])->name('teacher.profile.edit');
    Route::post('/teacher/profile', [TeacherProfileController::class, 'store'])->name('teacher.profile.store');
    Route::put('/teacher/profile',  [TeacherProfileController::class, 'update'])->name('teacher.profile.update');

    Route::resource('listings', ListingController::class);
});

require __DIR__ . '/auth.php';
