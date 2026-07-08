<?php

namespace App\Domains\MatchFactory\Contracts;

use App\Models\ShootingMatch;

interface MatchFactoryServiceInterface
{
    public function generateFirestrings(ShootingMatch $match, string $courseId): array;
}
