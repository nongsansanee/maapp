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

Route::get('/application/index', [ApplicationController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('application.index');

//Route::get('/application/create',  function () {
//    return Inertia::render('ApplicationCreate');
//})->name('application.create');

Route::get('/application/create', [ApplicationController::class, 'create'])
    ->middleware(['auth', 'verified'])->name('application.create');

Route::post('/application/store', [ApplicationController::class, 'store'])
    ->name('application.store');

Route::get('/application/{application}/edit', [ApplicationController::class, 'edit'])
    ->middleware(['auth', 'verified'])->name('application.edit');

Route::patch('/application/{application}/update', [ApplicationController::class, 'update'])
    ->middleware(['auth', 'verified'])->name('application.update');

//Route::delete('/application/{application}/destroy', [ApplicationController::class, 'destroy'])
//    ->middleware(['auth', 'verified'])->name('application.destroy');

require __DIR__ . '/settings.php';
require __DIR__ . '/ma_app.php';