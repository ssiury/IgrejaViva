<?php

use App\Modules\InformacaoIgreja\Http\Controllers\InformacaoIgrejaController;
use Illuminate\Support\Facades\Route;

Route::get('/informacoes-igreja', [InformacaoIgrejaController::class, 'show'])->name('informacoes-igreja.show');
