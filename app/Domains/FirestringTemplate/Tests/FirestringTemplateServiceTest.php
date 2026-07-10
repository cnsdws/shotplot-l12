<?php

namespace App\Domains\FirestringTemplate\Tests;

use App\Domains\CoursePlanner\DTOs\StagePlan;
use App\Domains\FirestringTemplate\Contracts\FirestringTemplateServiceInterface;
use App\Domains\FirestringTemplate\DTOs\FirestringTemplate;
use App\Domains\Position\DTOs\PositionDefinition;
use App\Domains\Stage\DTOs\StageDefinition;
use App\Domains\Target\DTOs\TargetDefinition;
use Tests\TestCase;

class FirestringTemplateServiceTest extends TestCase
{
    public function test_service_resolves_from_container(): void
    {
        $service = app(FirestringTemplateServiceInterface::class);

        $this->assertInstanceOf(
            FirestringTemplateServiceInterface::class,
            $service
        );
    }

    public function test_it_builds_a_template_from_a_stage_plan(): void
    {
        $service = app(FirestringTemplateServiceInterface::class);

        $stagePlan = new StagePlan(
            number: 1,
            stage: new StageDefinition(
                id: 'nra-hp-200-slow-standing',
                name: '200 Yard Slow Fire',
                positionId: 'standing',
                targetId: 'SR',
                fireType: 'slow',
                distance: 200,
                distanceUnit: 'yards',
                shotCount: 10,
            ),
            position: new PositionDefinition(
                id: 'standing',
                name: 'Standing',
                allowsSlingSupport: false,
                allowsMagazineSupport: false,
                description: 'Erect on both feet with no other portion of the body touching the ground or support.',
            ),
            target: new TargetDefinition(
                id: 'SR',
                label: 'SR - 200 Yard High Power',
                distanceYards: 200,
                blackRings: [9, 10, 'X'],
                rings: [],
            ),
        );

        $template = $service->build($stagePlan);

        $this->assertInstanceOf(
            FirestringTemplate::class,
            $template
        );

        $this->assertSame(1, $template->number);

        $this->assertSame(
            '200 Yard Slow Fire',
            $template->stageName
        );

        $this->assertSame(
            10,
            $template->shotCount
        );

        $this->assertSame(
            'SR - 200 Yard High Power',
            $template->target
        );

        $this->assertSame(0, $template->windSpeed);
        $this->assertSame(0, $template->elevation);
        $this->assertSame(0, $template->windage);
    }

    public function test_it_maps_to_the_legacy_firestring_schema(): void
    {
        $service = app(FirestringTemplateServiceInterface::class);

        $stagePlan = new StagePlan(
            number: 4,
            stage: new StageDefinition(
                id: 'nra-hp-600-slow-prone',
                name: '600 Yard Slow Fire',
                positionId: 'prone',
                targetId: 'MR-1',
                fireType: 'slow',
                distance: 600,
                distanceUnit: 'yards',
                shotCount: 20,
            ),
            position: new PositionDefinition(
                id: 'prone',
                name: 'Prone',
                allowsSlingSupport: true,
                allowsMagazineSupport: false,
                description: 'Body extended on the ground, head toward the target.',
            ),
            target: new TargetDefinition(
                id: 'MR-1',
                label: 'MR-1 - 600 Yard Mid-Range',
                distanceYards: 600,
                blackRings: [7, 8, 9, 10, 'X'],
                rings: [],
            ),
        );

        $attributes = $service
            ->build($stagePlan)
            ->toLegacyAttributes(42);

        $this->assertSame(
            42,
            $attributes['match_id']
        );

        $this->assertSame(
            4,
            $attributes['fire_string_number']
        );

        $this->assertSame(
            '600 Yard Slow Fire',
            $attributes['distance']
        );

        $this->assertSame(
            '',
            $attributes['target']
        );

        $this->assertArrayNotHasKey(
            'shot_count',
            $attributes
        );
    }
}
