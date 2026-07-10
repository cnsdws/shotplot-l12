<?php

namespace App\Domains\CoursePlanner\DTOs;

use App\Domains\Position\DTOs\PositionDefinition;
use App\Domains\Stage\DTOs\StageDefinition;
use App\Domains\Target\DTOs\TargetDefinition;

final readonly class StagePlan
{
    public function __construct(
        public int $number,
        public StageDefinition $stage,
        public ?PositionDefinition $position,
        public ?TargetDefinition $target,
    ) {
    }
}
