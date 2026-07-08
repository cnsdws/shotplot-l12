<?php

namespace App\Domains\RuleSet\Contracts;

interface RuleSetServiceInterface
{
    public function all(): array;

    public function get(string $id): ?array;

    public function exists(string $id): bool;

    public function ids(): array;
}
