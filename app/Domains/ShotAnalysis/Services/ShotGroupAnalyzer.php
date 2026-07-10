<?php

namespace App\Domains\ShotAnalysis\Services;

use App\Domains\Shot\DTOs\Shot;
use App\Domains\Shot\DTOs\ShotCollection;
use App\Domains\ShotAnalysis\Contracts\ShotGroupAnalyzerInterface;
use App\Domains\ShotAnalysis\DTOs\ShotGroupMetrics;

final class ShotGroupAnalyzer implements ShotGroupAnalyzerInterface
{
    public function analyze(
        ShotCollection $shots
    ): ShotGroupMetrics {
        $plotted = array_values(
            array_filter(
                $shots->all(),
                fn (Shot $shot): bool =>
                    $shot->x !== null && $shot->y !== null
            )
        );

        $count = count($plotted);

        if ($count === 0) {
            return new ShotGroupMetrics(
                plottedShotCount: 0,
                centerX: null,
                centerY: null,
                horizontalSpread: null,
                verticalSpread: null,
                extremeSpread: null,
                meanRadius: null,
            );
        }

        $centerX = array_sum(
            array_map(
                fn (Shot $shot): int => $shot->x,
                $plotted
            )
        ) / $count;

        $centerY = array_sum(
            array_map(
                fn (Shot $shot): int => $shot->y,
                $plotted
            )
        ) / $count;

        $xValues = array_map(
            fn (Shot $shot): int => $shot->x,
            $plotted
        );

        $yValues = array_map(
            fn (Shot $shot): int => $shot->y,
            $plotted
        );

        $horizontalSpread = max($xValues) - min($xValues);
        $verticalSpread = max($yValues) - min($yValues);

        $extremeSpread = $this->extremeSpread($plotted);

        $meanRadius = array_sum(
            array_map(
                fn (Shot $shot): float => $this->distance(
                    $shot->x,
                    $shot->y,
                    $centerX,
                    $centerY
                ),
                $plotted
            )
        ) / $count;

        return new ShotGroupMetrics(
            plottedShotCount: $count,
            centerX: $centerX,
            centerY: $centerY,
            horizontalSpread: (float) $horizontalSpread,
            verticalSpread: (float) $verticalSpread,
            extremeSpread: $extremeSpread,
            meanRadius: $meanRadius,
        );
    }

    /**
     * @param array<int, Shot> $shots
     */
    private function extremeSpread(array $shots): float
    {
        $largestDistance = 0.0;
        $count = count($shots);

        for ($first = 0; $first < $count; $first++) {
            for ($second = $first + 1; $second < $count; $second++) {
                $distance = $this->distance(
                    $shots[$first]->x,
                    $shots[$first]->y,
                    $shots[$second]->x,
                    $shots[$second]->y
                );

                $largestDistance = max(
                    $largestDistance,
                    $distance
                );
            }
        }

        return $largestDistance;
    }

    private function distance(
        float $x1,
        float $y1,
        float $x2,
        float $y2
    ): float {
        return sqrt(
            (($x2 - $x1) ** 2)
            + (($y2 - $y1) ** 2)
        );
    }
}
