<?php

namespace App\Domains\Target\Services;

use App\Domains\Target\Contracts\TargetServiceInterface;

class TargetService implements TargetServiceInterface
{
    protected array $targets;

    public function __construct()
    {
        $this->targets = require app_path(
            'Domains/Target/Data/target_definitions.php'
        );
    }

    public function all(): array
    {
        return $this->targets;
    }

    public function get(string $target): ?array
    {
        return $this->targets[$target] ?? null;
    }
}
