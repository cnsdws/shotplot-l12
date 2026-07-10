<?php

namespace App\Domains\ShotAnalysis\Tests;

use App\Domains\Shot\DTOs\Shot;
use App\Domains\Shot\DTOs\ShotCollection;
use App\Domains\ShotAnalysis\Contracts\ShotGroupAnalyzerInterface;
use App\Domains\ShotAnalysis\DTOs\ShotGroupMetrics;
use Tests\TestCase;

class ShotGroupAnalyzerTest extends TestCase
{
    public function test_service_resolves_from_container(): void
    {
        $analyzer = app(ShotGroupAnalyzerInterface::class);

        $this->assertInstanceOf(
            ShotGroupAnalyzerInterface::class,
            $analyzer
        );
    }

    public function test_it_calculates_basic_group_metrics(): void
    {
        $shots = new ShotCollection([
            new Shot(1, '10', 0, 0),
            new Shot(2, '10', 3, 0),
            new Shot(3, '10', 0, 4),
        ]);

        $metrics = app(ShotGroupAnalyzerInterface::class)
            ->analyze($shots);

        $this->assertInstanceOf(
            ShotGroupMetrics::class,
            $metrics
        );

        $this->assertSame(3, $metrics->plottedShotCount);
        $this->assertEqualsWithDelta(1.0, $metrics->centerX, 0.0001);
        $this->assertEqualsWithDelta(4 / 3, $metrics->centerY, 0.0001);
        $this->assertEqualsWithDelta(3.0, $metrics->horizontalSpread, 0.0001);
        $this->assertEqualsWithDelta(4.0, $metrics->verticalSpread, 0.0001);
        $this->assertEqualsWithDelta(5.0, $metrics->extremeSpread, 0.0001);
        $this->assertEqualsWithDelta(
            2.3061229,
            $metrics->meanRadius,
            0.0001
        );
    }

    public function test_it_ignores_unplotted_shots(): void
    {
        $shots = new ShotCollection([
            new Shot(1, '10', 100, 100),
            new Shot(2, '9', null, null),
            new Shot(3, '8', 110, 100),
        ]);

        $metrics = app(ShotGroupAnalyzerInterface::class)
            ->analyze($shots);

        $this->assertSame(2, $metrics->plottedShotCount);
        $this->assertEqualsWithDelta(105.0, $metrics->centerX, 0.0001);
        $this->assertEqualsWithDelta(100.0, $metrics->centerY, 0.0001);
        $this->assertEqualsWithDelta(10.0, $metrics->extremeSpread, 0.0001);
        $this->assertEqualsWithDelta(5.0, $metrics->meanRadius, 0.0001);
    }

    public function test_empty_collection_returns_empty_metrics(): void
    {
        $metrics = app(ShotGroupAnalyzerInterface::class)
            ->analyze(new ShotCollection([]));

        $this->assertFalse($metrics->hasPlottedShots());
        $this->assertSame(0, $metrics->plottedShotCount);
        $this->assertNull($metrics->centerX);
        $this->assertNull($metrics->centerY);
        $this->assertNull($metrics->extremeSpread);
        $this->assertNull($metrics->meanRadius);
    }
}
