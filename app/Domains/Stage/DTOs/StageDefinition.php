<?php

namespace App\Domains\Stage\DTOs;

final readonly class StageDefinition
{
    public function __construct(
        public string $id,
        public string $name,
        public string $positionId,
        public string $targetId,
        public string $fireType,
        public int $distance,
        public string $distanceUnit,
        public int $shotCount,
    ) {
    }

    public static function fromArray(array $definition): self
    {
        return new self(
            id: $definition['id'],
            name: $definition['name'],
            positionId: $definition['positionId'],
            targetId: $definition['targetId'],
            fireType: $definition['fireType'],
            distance: $definition['distance'],
            distanceUnit: $definition['distanceUnit'],
            shotCount: $definition['shotCount'],
        );
    }
}
