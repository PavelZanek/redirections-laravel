<?php

use Illuminate\Support\Facades\Route;
use PavelZanek\RedirectionsLaravel\Http\Controllers\RedirectController;

Route::get('/redirects/export', [RedirectController::class, 'export'])->name('redirects.export');
Route::post('/redirects/import', [RedirectController::class, 'import'])->name('redirects.import');
Route::resource('redirects', RedirectController::class);