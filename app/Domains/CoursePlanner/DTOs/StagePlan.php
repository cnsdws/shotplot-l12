<?php

namespace App\Domains\CoursePlanner\DTOs;

class StagePlan
{
    public function __construct(
        public int $number,
        public array $stage,
        public ?array $position,
        public ?array $target,
    ) {
    }
}
