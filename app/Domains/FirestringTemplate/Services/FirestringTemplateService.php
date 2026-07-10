<?php

namespace App\Domains\FirestringTemplate\Services;

use App\Domains\CoursePlanner\DTOs\StagePlan;
use App\Domains\FirestringTemplate\Contracts\FirestringTemplateServiceInterface;
use App\Domains\FirestringTemplate\DTOs\FirestringTemplate;
use InvalidArgumentException;

final class FirestringTemplateService implements FirestringTemplateServiceInterface
{
    public function build(StagePlan $stagePlan): FirestringTemplate
    {
        $stage = $stagePlan->stage;
        $target = $stagePlan->target;

        $stageName = $stage['name'] ?? null;
        $shotCount = $stage['shotCount'] ?? null;

        if (! is_string($stageName) || $stageName === '') {
            throw new InvalidArgumentException(
                "Stage {$stagePlan->number} does not define a valid name."
            );
        }

        if (! is_int($shotCount) || $shotCount < 1) {
            throw new InvalidArgumentException(
                "Stage {$stagePlan->number} does not define a valid shot count."
            );
        }

        return new FirestringTemplate(
            number: $stagePlan->number,
            stageName: $stageName,
            shotCount: $shotCount,
            target: is_array($target)
                ? (string) ($target['label'] ?? '')
                : '',
        );
    }
}
