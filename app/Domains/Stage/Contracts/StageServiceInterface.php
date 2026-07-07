<?php

namespace App\Domains\Stage\Contracts;

interface StageServiceInterface
{
    public function all(): array;

    public function get(string $id): ?array;
}
