<?php

namespace App\Domains\Target\DTOs;

final readonly class TargetDefinition
{
    public function __construct(
        public string $id,
        public string $label,
        public int $distanceYards,
        public array $blackRings,
        public array $rings,
    ) {
    }

    public static function fromArray(
        string $id,
        array $definition
    ): self {
        return new self(
            id: $id,
            label: $definition['label'],
            distanceYards: $definition['distanceYards'],
            blackRings: $definition['blackRings'],
            rings: $definition['rings'],
        );
    }
}
