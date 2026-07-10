<?php

namespace App\Domains\MatchFactory\Services;

use App\Domains\CoursePlanner\Contracts\CoursePlannerServiceInterface;
use App\Domains\MatchFactory\Contracts\MatchFactoryServiceInterface;
use App\Models\Firestring;
use App\Models\ShootingMatch;

class MatchFactoryService implements MatchFactoryServiceInterface
{
    public function __construct(
        protected CoursePlannerServiceInterface $coursePlanner,
    ) {
    }

    public function generateFirestrings(ShootingMatch $match, string $courseId): array
    {
        $plan = $this->coursePlanner->buildPlan($courseId);

        if (empty($plan->stages)) {
            return [];
        }

        $created = [];

        foreach ($plan->stages as $stagePlan) {
            $stage = $stagePlan->stage;
            $target = $stagePlan->target;
            
            $created[] = Firestring::create([
                'match_id' => $match->id,
                'fire_string_number' => $stagePlan->number,
                'distance' => $stage['name'],
                'shot_count' => $stage['shotCount'],
                'target' => $target['label'] ?? '',
                'relay' => '',
                'lightdirection' => '',
                'winddirection' => '',
                'windspeed' => 0,
                'temperature' => '',
                'sky_condition' => '',
                'range_notes' => '',
                'elevation' => 0,
                'windage' => 0,
            ]);
        }

        return $created;
    }
}
