<?php

namespace App\Domains\CoursePlanner\Services;

use App\Domains\Course\Contracts\CourseServiceInterface;
use App\Domains\CoursePlanner\Contracts\CoursePlannerServiceInterface;
use App\Domains\CoursePlanner\DTOs\CoursePlan;
use App\Domains\CoursePlanner\DTOs\StagePlan;
use App\Domains\Position\Contracts\PositionServiceInterface;
use App\Domains\RuleSet\Contracts\RuleSetServiceInterface;
use App\Domains\Stage\Contracts\StageServiceInterface;
use App\Domains\Target\Contracts\TargetServiceInterface;

class CoursePlannerService implements CoursePlannerServiceInterface
{
    public function __construct(
        protected CourseServiceInterface $courses,
        protected StageServiceInterface $stages,
        protected PositionServiceInterface $positions,
        protected TargetServiceInterface $targets,
        protected RuleSetServiceInterface $ruleSets,
    ) {
    }

    public function buildPlan(string $courseId): CoursePlan
    {
        $course = $this->courses->get($courseId);

        if (! $course) {
            return new CoursePlan([], null, []);
        }

        $ruleSet = $this->ruleSets->get(
            $course['ruleSetId'] ?? ''
        );

        $resolvedStages = [];

        foreach ($course['stages'] as $index => $stageId) {
            $stage = $this->stages->get($stageId);

            if (! $stage) {
                continue;
            }

            $position = $this->positions->get(
                $stage->positionId
            );

            $target = $this->targets->get(
                $stage->targetId
            );

            $resolvedStages[] = new StagePlan(
                number: $index + 1,
                stage: $stage,
                position: $position,
                target: $target,
            );
        }

        return new CoursePlan(
            course: $course,
            ruleSet: $ruleSet,
            stages: $resolvedStages,
        );
    }
}
