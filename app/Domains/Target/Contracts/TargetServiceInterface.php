<?php

namespace App\Domains\Target\Contracts;

use App\Domains\Target\DTOs\TargetDefinition;

interface TargetServiceInterface
{
    /**
     * @return array<string, TargetDefinition>
     */
    public function all(): array;

    public function get(string $target): ?TargetDefinition;
}
