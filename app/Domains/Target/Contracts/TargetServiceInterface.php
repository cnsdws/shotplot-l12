<?php

namespace App\Domains\Target\Contracts;

interface TargetServiceInterface
{
    public function all(): array;

    public function get(string $target): ?array;
    
    public function targetForStage(string $stage): string;
}
