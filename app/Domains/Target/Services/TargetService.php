<?php

namespace App\Domains\Target\Services;

use App\Domains\Target\Contracts\TargetServiceInterface;
use App\Domains\Target\DTOs\TargetDefinition;

class TargetService implements TargetServiceInterface
{
    /**
     * @var array<string, TargetDefinition>
     */
    protected array $targets;

    public function __construct()
    {
        $definitions = require app_path(
            'Domains/Target/Data/target_definitions.php'
        );

        $this->targets = collect($definitions)
            ->map(
                fn (array $definition, string $id) =>
                    TargetDefinition::fromArray($id, $definition)
            )
            ->all();
    }

    public function all(): array
    {
        return $this->targets;
    }

    public function get(string $target): ?TargetDefinition
    {
        return $this->targets[$target] ?? null;
    }
}
