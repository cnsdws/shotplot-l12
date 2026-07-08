<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Domains\Target\Contracts\TargetServiceInterface;
use App\Domains\Target\Services\TargetService;
use App\Domains\Position\Contracts\PositionServiceInterface;
use App\Domains\Position\Services\PositionService;
use App\Domains\Stage\Contracts\StageServiceInterface;
use App\Domains\Stage\Services\StageService;
use App\Domains\Course\Contracts\CourseServiceInterface;
use App\Domains\Course\Services\CourseService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(
            TargetServiceInterface::class,
            TargetService::class
        );

        $this->app->singleton(
            PositionServiceInterface::class,
            PositionService::class
        );
        
        $this->app->singleton(
            StageServiceInterface::class,
            StageService::class
        );
        
        $this->app->singleton(
            CourseServiceInterface::class,
            CourseService::class
        );
        
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
