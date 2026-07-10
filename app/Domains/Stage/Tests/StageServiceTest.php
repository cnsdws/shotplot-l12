<?php

namespace App\Domains\Stage\Tests;

use App\Domains\Stage\Contracts\StageServiceInterface;
use App\Domains\Stage\DTOs\StageDefinition;
use Tests\TestCase;

class StageServiceTest extends TestCase
{
    public function test_service_returns_typed_stage_definitions(): void
    {
        $service = app(StageServiceInterface::class);

        $stage = $service->get(
            'nra-hp-300-rapid-prone'
        );

        $this->assertInstanceOf(
            StageDefinition::class,
            $stage
        );

        $this->assertSame(
            '300 Yard Rapid Fire',
            $stage->name
        );

        $this->assertSame('prone', $stage->positionId);
        $this->assertSame('SR-3', $stage->targetId);
        $this->assertSame(300, $stage->distance);
        $this->assertSame(10, $stage->shotCount);
    }

    public function test_unknown_stage_returns_null(): void
    {
        $service = app(StageServiceInterface::class);

        $this->assertNull(
            $service->get('not-a-real-stage')
        );
    }
}
