<?php

namespace App\Domains\Stage\Services;

use App\Domains\Stage\Contracts\StageServiceInterface;

class StageService implements StageServiceInterface
{
    protected array $stages;

    public function __construct()
    {
        $this->stages = require app_path(
            'Domains/Stage/Data/stage_definitions.php'
        );
    }

    public function all(): array
    {
        return $this->stages;
    }

    public function get(string $id): ?array
    {
        return $this->stages[$id] ?? null;
    }
}
