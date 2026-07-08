<?php

namespace App\Domains\MatchFactory\Services;

use App\Domains\CourseResolver\Contracts\CourseResolverInterface;
use App\Domains\MatchFactory\Contracts\MatchFactoryServiceInterface;
use App\Models\Firestring;
use App\Models\ShootingMatch;

class MatchFactoryService implements MatchFactoryServiceInterface
{
    public function __construct(
        protected CourseResolverInterface $courseResolver,
    ) {
    }

    public function generateFirestrings(ShootingMatch $match, string $courseId): array
    {
        $resolvedCourse = $this->courseResolver->resolve($courseId);

        if (empty($resolvedCourse)) {
            return [];
        }

        $created = [];

        foreach ($resolvedCourse['stages'] as $index => $resolvedStage) {
            $stage = $resolvedStage['stage'];

            $created[] = Firestring::create([
                'match_id' => $match->id,
                'fire_string_number' => $index + 1,
                'distance' => $stage['name'],
                'shot_count' => $stage['shotCount'],
            ]);
        }

        return $created;
    }
}
