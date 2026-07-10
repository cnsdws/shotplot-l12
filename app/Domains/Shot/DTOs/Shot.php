<?php

namespace App\Domains\Shot\DTOs;

final readonly class Shot
{
    public function __construct(
        public int $number,
        public ?string $value,
        public ?int $x,
        public ?int $y,
    ) {
    }

    public function normalizedValue(): string
    {
        return strtoupper(trim((string) $this->value));
    }

    public function isX(): bool
    {
        return $this->normalizedValue() === 'X';
    }

    public function score(): int
    {
        $value = $this->normalizedValue();

        if ($value === 'X') {
            return 10;
        }

        return is_numeric($value)
            ? (int) $value
            : 0;
    }
}
