<?php

namespace App\Modules\Culto\Providers;

use App\Modules\Culto\Repositories\Contracts\CultoRepositoryInterface;
use App\Modules\Culto\Repositories\Eloquent\CultoRepository;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class CultoServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(CultoRepositoryInterface::class, CultoRepository::class);
    }

    public function boot(): void
    {
        Route::prefix('api/v1')->middleware('api')->group(__DIR__.'/../routes.php');

        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }
}
