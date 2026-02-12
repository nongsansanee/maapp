<?php

use App\Http\Controllers\ApplicationController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canRegister' => Features::enabled(Features::registration()),
    ]);
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

//Route::get('/application/index', [ApplicationController::class, 'index'])
//    ->name('application.index');

Route::get('/application/create',  function () {
    return Inertia::render('ApplicationCreate');
})->name('application.create');

Route::post('/application/store', [ApplicationController::class, 'store'])->name('application.store');


require __DIR__ . '/settings.php';
require __DIR__ . '/ma_app.php';