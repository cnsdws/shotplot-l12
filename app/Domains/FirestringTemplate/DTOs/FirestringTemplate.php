<?php

namespace App\Domains\FirestringTemplate\DTOs;

final readonly class FirestringTemplate
{
    public function __construct(
        public int $number,
        public string $stageName,
        public int $shotCount,
        public string $target,
        public string $relay = '',
        public string $lightDirection = '',
        public string $windDirection = '',
        public int|float $windSpeed = 0,
        public string $temperature = '',
        public string $skyCondition = '',
        public string $rangeNotes = '',
        public int|float $elevation = 0,
        public int|float $windage = 0,
    ) {
    }

    public function toLegacyAttributes(int $matchId): array
    {
        return [
            'match_id' => $matchId,
            'fire_string_number' => $this->number,

            // Legacy schema currently stores the stage name in distance.
            'distance' => $this->stageName,

            'target' => $this->target,
            'relay' => $this->relay,
            'lightdirection' => $this->lightDirection,
            'winddirection' => $this->windDirection,
            'windspeed' => $this->windSpeed,
            'temperature' => $this->temperature,
            'sky_condition' => $this->skyCondition,
            'range_notes' => $this->rangeNotes,
            'elevation' => $this->elevation,
            'windage' => $this->windage,
        ];
    }
}
