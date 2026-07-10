<?php

namespace App\Domains\Position\DTOs;

final readonly class PositionDefinition
{
    public function __construct(
        public string $id,
        public string $name,
        public bool $allowsSlingSupport,
        public bool $allowsMagazineSupport,
        public string $description,
    ) {
    }

    public static function fromArray(array $definition): self
    {
        return new self(
            id: $definition['id'],
            name: $definition['name'],
            allowsSlingSupport: $definition['allowsSlingSupport'],
            allowsMagazineSupport: $definition['allowsMagazineSupport'],
            description: $definition['description'],
        );
    }
}
