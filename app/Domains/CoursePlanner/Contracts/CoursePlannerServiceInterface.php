<?php

namespace App\Domains\CoursePlanner\Contracts;

use App\Domains\CoursePlanner\DTOs\CoursePlan;

interface CoursePlannerServiceInterface
{
    public function buildPlan(string $courseId): CoursePlan;
}
