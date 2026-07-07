<?php

namespace App\Domains\Position\Contracts;

interface PositionServiceInterface
{
    public function all(): array;

    public function get(string $position): ?array;
}
