<?php

namespace Tests\Unit;

use App\Models\Firestring;
use Tests\TestCase;

class FirestringScoringTest extends TestCase
{
    public function test_existing_scoring_api_uses_shot_objects(): void
    {
        $firestring = new Firestring([
            'distance' => '200 Yard Slow Fire',
            'shot1value' => 'X',
            'shot2value' => '10',
            'shot3value' => '9',
            'shot4value' => '8',
        ]);

        $this->assertSame(37, $firestring->totalScore());
        $this->assertSame(1, $firestring->xCount());
        $this->assertSame('37-1X', $firestring->formattedScore());
        $this->assertCount(10, $firestring->shots());
    }
}
