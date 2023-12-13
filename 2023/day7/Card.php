<?php

declare(strict_types=1);

readonly class Card
{
    public function __construct(
        private string $card,
    ) {
    }

    public function getCard(): string
    {
        return $this->card;
    }

    public function getScore(): int
    {
        return match ($this->card) {
            'A' => 14,
            'K' => 13,
            'Q' => 12,
            'J' => 1,
            'T' => 10,
            '9' => 9,
            '8' => 8,
            '7' => 7,
            '6' => 6,
            '5' => 5,
            '4' => 4,
            '3' => 3,
            '2' => 2,
            default => 0,
        };
    }
}