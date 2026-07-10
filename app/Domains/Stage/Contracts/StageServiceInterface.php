<?php

namespace App\Domains\Stage\Contracts;

use App\Domains\Stage\DTOs\StageDefinition;

interface StageServiceInterface
{
    /**
     * @return array<string, StageDefinition>
     */
    public function all(): array;

    public function get(string $id): ?StageDefinition;
}
