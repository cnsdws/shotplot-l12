<?php

namespace App\Domains\Position\Tests;

use App\Domains\Position\Contracts\PositionServiceInterface;
use App\Domains\Position\DTOs\PositionDefinition;
use Tests\TestCase;

class PositionServiceTest extends TestCase
{
    public function test_service_returns_typed_position_definitions(): void
    {
        $service = app(PositionServiceInterface::class);

        $position = $service->get('prone');

        $this->assertInstanceOf(
            PositionDefinition::class,
            $position
        );

        $this->assertSame('Prone', $position->name);
        $this->assertTrue($position->allowsSlingSupport);
        $this->assertFalse($position->allowsMagazineSupport);
    }

    public function test_unknown_position_returns_null(): void
    {
        $service = app(PositionServiceInterface::class);

        $this->assertNull(
            $service->get('not-a-real-position')
        );
    }
}
