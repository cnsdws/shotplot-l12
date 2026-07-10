<?php

namespace App\Domains\Shot\Services;

use App\Domains\Shot\Contracts\LegacyShotMapperInterface;
use App\Domains\Shot\DTOs\Shot;
use App\Domains\Shot\DTOs\ShotCollection;
use App\Models\Firestring;

final class LegacyShotMapper implements LegacyShotMapperInterface
{
    public function fromFirestring(
        Firestring $firestring
    ): ShotCollection {
        $shots = [];

        for ($number = 1; $number <= $firestring->shot_count; $number++) {
            $shots[] = new Shot(
                number: $number,
                value: $this->nullableString(
                    $firestring->getAttribute("shot{$number}value")
                ),
                x: $this->nullableInteger(
                    $firestring->getAttribute("shot{$number}x")
                ),
                y: $this->nullableInteger(
                    $firestring->getAttribute("shot{$number}y")
                ),
            );
        }

        return new ShotCollection($shots);
    }

    private function nullableString(mixed $value): ?string
    {
        if ($value === null || $value === '') {
            return null;
        }

        return (string) $value;
    }

    private function nullableInteger(mixed $value): ?int
    {
        if ($value === null || $value === '') {
            return null;
        }

        return (int) $value;
    }
}
