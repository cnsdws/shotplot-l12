<?php

namespace App\Domains\CoursePlanner\DTOs;

use App\Domains\Stage\DTOs\StageDefinition;

final readonly class StagePlan
{
    public function __construct(
        public int $number,
        public StageDefinition $stage,
        public ?array $position,
        public ?array $target,
    ) {
    }
}
