<?php

use Illuminate\Support\Facades\Route;
use PavelZanek\RedirectionsLaravel\Http\Controllers\RedirectController;

Route::resource('redirects', RedirectController::class);