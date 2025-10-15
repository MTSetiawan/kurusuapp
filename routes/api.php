<?php

use App\Http\Controllers\AdminPlanRequest;
use App\Http\Controllers\PublicListingController;
use Illuminate\Support\Facades\Route;

Route::get('/public-listing', [PublicListingController::class, 'landing']);
