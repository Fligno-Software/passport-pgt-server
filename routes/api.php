<?php

use Illuminate\Support\Facades\Route;

Route::prefix('oauth')->middleware('auth:api')->group(function () {
    Route::post('logout', passportPgtServer()->getLogoutAuthController())->name('logout');
    Route::get('me', passportPgtServer()->getMeAuthController())->name('me');
});
