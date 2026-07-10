<?php

namespace App\Domains\FirestringTemplate\Services;

use App\Domains\CoursePlanner\DTOs\StagePlan;
use App\Domains\FirestringTemplate\Contracts\FirestringTemplateServiceInterface;
use App\Domains\FirestringTemplate\DTOs\FirestringTemplate;

final class FirestringTemplateService implements FirestringTemplateServiceInterface
{
    public function build(StagePlan $stagePlan): FirestringTemplate
    {
        return new FirestringTemplate(
            number: $stagePlan->number,
            stageName: $stagePlan->stage->name,
            shotCount: $stagePlan->stage->shotCount,
            target: $stagePlan->target?->label ?? '',
        );
    }
}
