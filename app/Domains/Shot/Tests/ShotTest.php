<?php

namespace App\Domains\Shot\Tests;

use App\Domains\Shot\DTOs\Shot;
use PHPUnit\Framework\TestCase;

class ShotTest extends TestCase
{
    public function test_x_scores_ten_points(): void
    {
        $shot = new Shot(
            number: 1,
            value: 'x',
            x: 250,
            y: 250,
        );

        $this->assertTrue($shot->isX());
        $this->assertSame(10, $shot->score());
        $this->assertSame('X', $shot->normalizedValue());
    }

    public function test_numeric_value_returns_numeric_score(): void
    {
        $shot = new Shot(
            number: 2,
            value: '9',
            x: null,
            y: null,
        );

        $this->assertFalse($shot->isX());
        $this->assertSame(9, $shot->score());
    }

    public function test_blank_value_scores_zero(): void
    {
        $shot = new Shot(
            number: 3,
            value: null,
            x: null,
            y: null,
        );

        $this->assertSame(0, $shot->score());
    }
}
