<?php

namespace App\Domains\CoursePlanner\DTOs;

class CoursePlan
{
    public function __construct(
        public array $course,
        public ?array $ruleSet,
        public array $stages,
    ) {
    }
}
