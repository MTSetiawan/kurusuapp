<?php

use App\Http\Controllers\ListingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicListingController;
use App\Http\Controllers\TeacherProfileController;
use Illuminate\Support\Facades\Route;
use App\Models\Listing; // ⬅️ add this

Route::get('/', [PublicListingController::class, 'landing'])->name('landing');

Route::get('/kursus', [PublicListingController::class, 'catalog'])->name('catalog');

Route::get('/kursus/{slug}/{region:slug}', [PublicListingController::class, 'show'])->name('listing.show');

/**
 * WhatsApp redirect tracker
 * - Increments wa_clicks (if the column exists)
 * - Builds a wa.me link from teacher profile number (fallback: just open WA with text)
 */
Route::get('/go/wa/{listing}', function (Listing $listing) {
    try { $listing->increment('wa_clicks'); } catch (\Throwable $e) { /* column may not exist yet */ }

    $teacher = optional($listing->user)->teacherProfile;
    $number  = $teacher->whatsapp_number ?? null;

    // build message
    $msg = 'Halo Kak ' . ($listing->user->name ?? 'Guru')
        . ', saya lihat listing ' . $listing->title
        . ' di ' . ($listing->region->name ?? 'kota Anda') . '.';

    $to   = $number ? preg_replace('/\D+/', '', $number) : '';
    $href = $to
        ? 'https://wa.me/' . $to . '?text=' . urlencode($msg)
        : 'https://wa.me/?text=' . urlencode($msg);

    return redirect()->away($href);
})->name('go.wa');

Route::middleware('auth')->group(function () {
    Route::get('/teacher', fn() => view('teacher.dashboard'))->name('teacher.dashboard');
    Route::get('/teacher/profile', [TeacherProfileController::class, 'edit'])->name('teacher.profile.edit');
    Route::post('/teacher/profile', [TeacherProfileController::class, 'store'])->name('teacher.profile.store');
    Route::put('/teacher/profile',  [TeacherProfileController::class, 'update'])->name('teacher.profile.update');

    Route::resource('listings', ListingController::class);
});

require __DIR__ . '/auth.php';
