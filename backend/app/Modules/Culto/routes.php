<?php

use App\Modules\Culto\Http\Controllers\CultoController;
use Illuminate\Support\Facades\Route;

Route::get('/cultos', [CultoController::class, 'index'])->name('cultos.index');
