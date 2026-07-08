<?php

namespace App\Domains\Course\Contracts;

interface CourseServiceInterface
{
    public function all(): array;

    public function get(string $id): ?array;
}
