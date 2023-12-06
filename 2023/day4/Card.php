<?php

declare(strict_types=1);

class Card
{
    public function __construct(
        private readonly int $id,
        private readonly array $winningNumbers,
        private readonly array $numbers,
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getScore(): int
    {
        return count(array_intersect($this->winningNumbers, $this->numbers));
    }
}
