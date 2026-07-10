<?php

namespace App\Domains\MatchFactory\Services;

use App\Domains\CoursePlanner\Contracts\CoursePlannerServiceInterface;
use App\Domains\FirestringTemplate\Contracts\FirestringTemplateServiceInterface;
use App\Domains\MatchFactory\Contracts\MatchFactoryServiceInterface;
use App\Models\Firestring;
use App\Models\ShootingMatch;

class MatchFactoryService implements MatchFactoryServiceInterface
{
    public function __construct(
        protected CoursePlannerServiceInterface $coursePlanner,
        protected FirestringTemplateServiceInterface $templateService,
    ) {
    }

    public function generateFirestrings(
        ShootingMatch $match,
        string $courseId
    ): array {
        $plan = $this->coursePlanner->buildPlan($courseId);

        if (empty($plan->stages)) {
            return [];
        }

        $created = [];

        foreach ($plan->stages as $stagePlan) {
            $template = $this->templateService->build($stagePlan);

            $created[] = Firestring::create(
                $template->toLegacyAttributes($match->id)
            );
        }

        return $created;
    }
}
