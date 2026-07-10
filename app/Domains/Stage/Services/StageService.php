<?php

namespace App\Domains\Stage\Services;

use App\Domains\Stage\Contracts\StageServiceInterface;
use App\Domains\Stage\DTOs\StageDefinition;

class StageService implements StageServiceInterface
{
    /**
     * @var array<string, StageDefinition>
     */
    protected array $stages;

    public function __construct()
    {
        $definitions = require app_path(
            'Domains/Stage/Data/stage_definitions.php'
        );

        $this->stages = collect($definitions)
            ->map(
                fn (array $definition) =>
                    StageDefinition::fromArray($definition)
            )
            ->all();
    }

    public function all(): array
    {
        return $this->stages;
    }

    public function get(string $id): ?StageDefinition
    {
        return $this->stages[$id] ?? null;
    }
}
