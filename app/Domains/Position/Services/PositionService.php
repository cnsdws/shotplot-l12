<?php

namespace App\Domains\Position\Services;

use App\Domains\Position\Contracts\PositionServiceInterface;

class PositionService implements PositionServiceInterface
{
    protected array $positions;

    public function __construct()
    {
        $this->positions = require app_path(
            'Domains/Position/Data/position_definitions.php'
        );
    }

    public function all(): array
    {
        return $this->positions;
    }

    public function get(string $position): ?array
    {
        return $this->positions[$position] ?? null;
    }
}
