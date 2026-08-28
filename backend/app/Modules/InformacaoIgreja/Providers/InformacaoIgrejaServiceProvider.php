<?php

namespace App\Modules\InformacaoIgreja\Providers;

use App\Modules\InformacaoIgreja\Repositories\Contracts\InformacaoIgrejaRepositoryInterface;
use App\Modules\InformacaoIgreja\Repositories\Eloquent\InformacaoIgrejaRepository;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class InformacaoIgrejaServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(InformacaoIgrejaRepositoryInterface::class, InformacaoIgrejaRepository::class);
    }

    public function boot(): void
    {
        Route::prefix('api/v1')->middleware('api')->group(__DIR__.'/../routes.php');

        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }
}
