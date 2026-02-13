<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\RequestController;

// Route::get('/application/index',  function () {
//     return Inertia::render('ApplicationIndex');
// })->name('application.index');

Route::get('/request', [RequestController::class, 'index'])->name('request.index');

Route::get('/request/create', [RequestController::class, 'create'])->middleware(['auth'])->name('request.create');

Route::post('/request/store', [RequestController::class, 'store'])->name('request.store');

Route::get('/request/edit/{request}', [RequestController::class, 'edit'])->name('request.edit');

Route::put('/request/update/{request_id}', [RequestController::class, 'update'])->name('request.update');