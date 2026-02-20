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

Route::patch('/request/update/{model_request}', [RequestController::class, 'update'])->name('request.update');

Route::put('/request/update_status/{request}', [RequestController::class, 'update_status'])->name('request.update_status');

Route::get('/request/show/{request}', [RequestController::class, 'show'])->name('request.show');

Route::delete('/request/destroy/{model_request}', [RequestController::class, 'destroy'])->name('request.destroy');