<?php

use App\Modules\SolicitacaoVisita\Http\Controllers\SolicitacaoVisitaController;
use Illuminate\Support\Facades\Route;

Route::post('/solicitacoes-visita', [SolicitacaoVisitaController::class, 'store'])->name('solicitacoes-visita.store');
