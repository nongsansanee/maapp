<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\RequestController;

// Route::get('/application/index',  function () {
//     return Inertia::render('ApplicationIndex');
// })->name('application.index');

Route::get('/application/index', [RequestController::class, 'index'])->name('application.index');

Route::get('/request/create', [RequestController::class, 'create'])->middleware(['auth'])->name('request.create');

Route::post('/request/store', [RequestController::class, 'store'])->name('request.store');
