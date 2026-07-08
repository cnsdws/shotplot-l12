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
use App\Domains\CoursePlanner\Contracts\CoursePlannerServiceInterface;
use App\Domains\CoursePlanner\Services\CoursePlannerService;
use App\Domains\RuleSet\Contracts\RuleSetServiceInterface;
use App\Domains\RuleSet\Services\RuleSetService;
use App\Domains\MatchFactory\Contracts\MatchFactoryServiceInterface;
use App\Domains\MatchFactory\Services\MatchFactoryService;

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
        
        $this->app->singleton(
            CoursePlannerServiceInterface::class,
            CoursePlannerService::class
        );
        
        $this->app->singleton(
            RuleSetServiceInterface::class,
            RuleSetService::class
        );
        
        $this->app->singleton(
            MatchFactoryServiceInterface::class,
            MatchFactoryService::class
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
