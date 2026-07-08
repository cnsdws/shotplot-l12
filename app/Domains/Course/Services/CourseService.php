<?php

namespace App\Domains\Course\Services;

use App\Domains\Course\Contracts\CourseServiceInterface;

class CourseService implements CourseServiceInterface
{
    protected array $courses;

    public function __construct()
    {
        $this->courses = require app_path(
            'Domains/Course/Data/course_definitions.php'
        );
    }

    public function all(): array
    {
        return $this->courses;
    }

    public function get(string $id): ?array
    {
        return $this->courses[$id] ?? null;
    }
}
