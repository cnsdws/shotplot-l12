<?php

namespace App\Domains\Shot\DTOs;

use Countable;
use IteratorAggregate;
use ArrayIterator;
use Traversable;

final readonly class ShotCollection implements Countable, IteratorAggregate
{
    /**
     * @param array<int, Shot> $shots
     */
    public function __construct(
        private array $shots,
    ) {
    }

    /**
     * @return array<int, Shot>
     */
    public function all(): array
    {
        return $this->shots;
    }

    public function totalScore(): int
    {
        return array_sum(
            array_map(
                fn (Shot $shot): int => $shot->score(),
                $this->shots
            )
        );
    }

    public function xCount(): int
    {
        return count(
            array_filter(
                $this->shots,
                fn (Shot $shot): bool => $shot->isX()
            )
        );
    }

    public function formattedScore(): string
    {
        return $this->totalScore()
            . '-'
            . $this->xCount()
            . 'X';
    }

    public function count(): int
    {
        return count($this->shots);
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->shots);
    }
}
