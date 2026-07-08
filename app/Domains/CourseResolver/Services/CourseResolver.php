<?php

namespace App\Domains\CourseResolver\Services;

use App\Domains\Course\Contracts\CourseServiceInterface;
use App\Domains\Stage\Contracts\StageServiceInterface;
use App\Domains\Position\Contracts\PositionServiceInterface;
use App\Domains\Target\Contracts\TargetServiceInterface;
use App\Domains\CourseResolver\Contracts\CourseResolverInterface;
use App\Domains\RuleSet\Contracts\RuleSetServiceInterface;

class CourseResolver implements CourseResolverInterface
{
    public function __construct(
        protected CourseServiceInterface $courses,
        protected StageServiceInterface $stages,
        protected PositionServiceInterface $positions,
        protected TargetServiceInterface $targets,
        protected RuleSetServiceInterface $ruleSets,
    ) {
    }

    public function resolve(string $courseId): array
    {
        $course = $this->courses->get($courseId);
        $ruleSet = $this->ruleSets->get($course['ruleSetId'] ?? '');

        if (!$course) {
            return [];
        }

        $resolvedStages = [];

        foreach ($course['stages'] as $stageId) {

            $stage = $this->stages->get($stageId);

            if (!$stage) {
                continue;
            }

            $position = $this->positions->get(
                $stage['positionId']
            );

            $targetId = $this->targets->targetForStage(
                $stage['name']
            );

            $target = $this->targets->get($targetId);

            $resolvedStages[] = [

                'stage' => $stage,

                'position' => $position,

                'target' => $target,

            ];
        }

        return [

            'course' => $course,
            'ruleSet' => $ruleSet,
            'stages' => $resolvedStages,

        ];
    }
}
