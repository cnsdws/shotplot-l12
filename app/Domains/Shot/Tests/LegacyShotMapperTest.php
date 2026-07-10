<?php

namespace App\Domains\Shot\Tests;

use App\Domains\Shot\Contracts\LegacyShotMapperInterface;
use App\Domains\Shot\DTOs\ShotCollection;
use App\Models\Firestring;
use Tests\TestCase;

class LegacyShotMapperTest extends TestCase
{
    public function test_service_resolves_from_container(): void
    {
        $mapper = app(LegacyShotMapperInterface::class);

        $this->assertInstanceOf(
            LegacyShotMapperInterface::class,
            $mapper
        );
    }

    public function test_it_maps_legacy_columns_into_shots(): void
    {
        $firestring = new Firestring([
            'distance' => '200 Yard Slow Fire',
            'shot1value' => 'X',
            'shot1x' => '250',
            'shot1y' => '245',
            'shot2value' => '9',
            'shot2x' => '275',
            'shot2y' => '260',
        ]);

        $shots = app(LegacyShotMapperInterface::class)
            ->fromFirestring($firestring);

        $this->assertInstanceOf(
            ShotCollection::class,
            $shots
        );

        $this->assertCount(10, $shots);
        $this->assertSame(19, $shots->totalScore());
        $this->assertSame(1, $shots->xCount());
        $this->assertSame('19-1X', $shots->formattedScore());

        $first = $shots->all()[0];

        $this->assertSame(1, $first->number);
        $this->assertSame('X', $first->value);
        $this->assertSame(250, $first->x);
        $this->assertSame(245, $first->y);
    }
}
