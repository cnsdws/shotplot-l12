<?php

namespace App\Domains\RuleSet\Services;

use App\Domains\RuleSet\Contracts\RuleSetServiceInterface;

class RuleSetService implements RuleSetServiceInterface
{
    protected array $definitions;

    public function __construct()
    {
        $this->definitions = require app_path(
            'Domains/RuleSet/Data/ruleset_definitions.php'
        );
    }

    public function all(): array
    {
        return $this->definitions;
    }

    public function get(string $id): ?array
    {
        return $this->definitions[$id] ?? null;
    }

    public function exists(string $id): bool
    {
        return isset($this->definitions[$id]);
    }

    public function ids(): array
    {
        return array_keys($this->definitions);
    }
}
