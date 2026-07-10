<?php

namespace App\Domains\ShotAnalysis\DTOs;

final readonly class ShotGroupMetrics
{
    public function __construct(
        public int $plottedShotCount,
        public ?float $centerX,
        public ?float $centerY,
        public ?float $horizontalSpread,
        public ?float $verticalSpread,
        public ?float $extremeSpread,
        public ?float $meanRadius,
    ) {
    }

    public function hasPlottedShots(): bool
    {
        return $this->plottedShotCount > 0;
    }
}
