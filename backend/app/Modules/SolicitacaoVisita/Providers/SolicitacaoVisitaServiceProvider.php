<?php

namespace App\Modules\SolicitacaoVisita\Providers;

use App\Modules\SolicitacaoVisita\Repositories\Contracts\SolicitacaoVisitaRepositoryInterface;
use App\Modules\SolicitacaoVisita\Repositories\Eloquent\SolicitacaoVisitaRepository;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class SolicitacaoVisitaServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(SolicitacaoVisitaRepositoryInterface::class, SolicitacaoVisitaRepository::class);
    }

    public function boot(): void
    {
        Route::prefix('api/v1')->middleware('api')->group(__DIR__.'/../routes.php');

        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }
}
