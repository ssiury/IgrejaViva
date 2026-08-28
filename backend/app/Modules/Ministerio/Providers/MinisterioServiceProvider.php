<?php

namespace App\Modules\Ministerio\Providers;

use App\Modules\Ministerio\Repositories\Contracts\MinisterioRepositoryInterface;
use App\Modules\Ministerio\Repositories\Eloquent\MinisterioRepository;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class MinisterioServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(MinisterioRepositoryInterface::class, MinisterioRepository::class);
    }

    public function boot(): void
    {
        Route::prefix('api/v1')->middleware('api')->group(__DIR__.'/../routes.php');

        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }
}
