<?php

namespace App\Domains\Position\Services;

use App\Domains\Position\Contracts\PositionServiceInterface;
use App\Domains\Position\DTOs\PositionDefinition;

class PositionService implements PositionServiceInterface
{
    /**
     * @var array<string, PositionDefinition>
     */
    protected array $positions;

    public function __construct()
    {
        $definitions = require app_path(
            'Domains/Position/Data/position_definitions.php'
        );

        $this->positions = collect($definitions)
            ->map(
                fn (array $definition) =>
                    PositionDefinition::fromArray($definition)
            )
            ->all();
    }

    public function all(): array
    {
        return $this->positions;
    }

    public function get(string $position): ?PositionDefinition
    {
        return $this->positions[$position] ?? null;
    }
}
