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
use App\Domains\Firestring\Contracts\FirestringServiceInterface;
use App\Domains\Firestring\Services\FirestringService;
use App\Domains\Shot\Contracts\LegacyShotMapperInterface;
use App\Domains\Shot\Services\LegacyShotMapper;
use App\Domains\ShotAnalysis\Contracts\ShotGroupAnalyzerInterface;
use App\Domains\ShotAnalysis\Services\ShotGroupAnalyzer;


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
        
        $this->app->bind(
            \App\Domains\FirestringTemplate\Contracts\FirestringTemplateServiceInterface::class,
            \App\Domains\FirestringTemplate\Services\FirestringTemplateService::class,
        );
        
        $this->app->bind(
            FirestringServiceInterface::class,
            FirestringService::class
        );
        
        $this->app->bind(
            LegacyShotMapperInterface::class,
            LegacyShotMapper::class
        );
        
        $this->app->bind(
            ShotGroupAnalyzerInterface::class,
            ShotGroupAnalyzer::class
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
