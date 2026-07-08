<?php

namespace App\Domains\CourseResolver\Contracts;

interface CourseResolverInterface
{
    public function resolve(string $courseId): array;
}
