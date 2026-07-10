<?php

namespace App\Domains\Position\Contracts;

use App\Domains\Position\DTOs\PositionDefinition;

interface PositionServiceInterface
{
    /**
     * @return array<string, PositionDefinition>
     */
    public function all(): array;

    public function get(string $position): ?PositionDefinition;
}
