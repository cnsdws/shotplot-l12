<?php

namespace App\Domains\ShotAnalysis\Contracts;

use App\Domains\Shot\DTOs\ShotCollection;
use App\Domains\ShotAnalysis\DTOs\ShotGroupMetrics;

interface ShotGroupAnalyzerInterface
{
    public function analyze(
        ShotCollection $shots
    ): ShotGroupMetrics;
}
