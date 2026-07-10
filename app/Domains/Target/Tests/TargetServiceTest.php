<?php

namespace App\Domains\Target\Tests;

use App\Domains\Target\Contracts\TargetServiceInterface;
use App\Domains\Target\DTOs\TargetDefinition;
use Tests\TestCase;

class TargetServiceTest extends TestCase
{
    public function test_service_returns_typed_target_definitions(): void
    {
        $service = app(TargetServiceInterface::class);

        $target = $service->get('SR-3');

        $this->assertInstanceOf(
            TargetDefinition::class,
            $target
        );

        $this->assertSame('SR-3', $target->id);
        $this->assertSame(
            'SR-3 - 300 Yard Rapid Prone',
            $target->label
        );
        $this->assertSame(300, $target->distanceYards);
        $this->assertContains('X', $target->blackRings);
    }

    public function test_unknown_target_returns_null(): void
    {
        $service = app(TargetServiceInterface::class);

        $this->assertNull(
            $service->get('not-a-real-target')
        );
    }
}
