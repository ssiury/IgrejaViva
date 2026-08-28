<?php

use App\Modules\Ministerio\Http\Controllers\MinisterioController;
use Illuminate\Support\Facades\Route;

Route::get('/ministerios', [MinisterioController::class, 'index'])->name('ministerios.index');
