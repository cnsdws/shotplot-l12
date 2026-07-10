<?php

namespace App\Domains\FirestringTemplate\Tests;

use App\Domains\CoursePlanner\DTOs\StagePlan;
use App\Domains\FirestringTemplate\Contracts\FirestringTemplateServiceInterface;
use App\Domains\FirestringTemplate\DTOs\FirestringTemplate;
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
            stage: [
                'name' => '200 Yard Slow Fire',
                'shotCount' => 10,
            ],
            position: [
                'id' => 'standing',
                'label' => 'Standing',
            ],
            target: [
                'id' => 'sr',
                'label' => 'SR',
            ],
        );

        $template = $service->build($stagePlan);

        $this->assertInstanceOf(FirestringTemplate::class, $template);
        $this->assertSame(1, $template->number);
        $this->assertSame('200 Yard Slow Fire', $template->stageName);
        $this->assertSame(10, $template->shotCount);
        $this->assertSame('SR', $template->target);
        $this->assertSame(0, $template->windSpeed);
        $this->assertSame(0, $template->elevation);
        $this->assertSame(0, $template->windage);
    }

    public function test_it_maps_to_the_legacy_firestring_schema(): void
    {
        $service = app(FirestringTemplateServiceInterface::class);

        $stagePlan = new StagePlan(
            number: 4,
            stage: [
                'name' => '600 Yard Slow Fire',
                'shotCount' => 20,
            ],
            position: [
                'id' => 'prone',
                'label' => 'Prone',
            ],
            target: [
                'id' => 'mr-1',
                'label' => 'MR-1',
            ],
        );

        $attributes = $service
            ->build($stagePlan)
            ->toLegacyAttributes(42);

        $this->assertSame(42, $attributes['match_id']);
        $this->assertSame(4, $attributes['fire_string_number']);
        $this->assertSame(
            '600 Yard Slow Fire',
            $attributes['distance']
        );
        $this->assertSame('MR-1', $attributes['target']);

        $this->assertArrayNotHasKey('shot_count', $attributes);
    }
}
