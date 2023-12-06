<?php

class Map
{
    private array $foundNumbers = [];

    public function __construct(
        private readonly array $lines,
    ) {
    }

    public function getCharacterAtPos(int $x, int $y): ?string {
        if ($y < 0 || $y > count($this->lines) - 1) {
            return null;
        }

        if ($x < 0 || $x > strlen($this->lines[$y]) - 1) {
            return null;
        }

        return $this->lines[$y][$x];
    }

    public function getNumberAtPos(int $x, int $y): ?int {
        $character = $this->getCharacterAtPos($x, $y);
        if (!is_numeric($character)) {
            return null;
        }

        $startX = $x;
        while(is_numeric($this->getCharacterAtPos($startX, $y))) {
            $startX--;
        }
        $startX++;

        $coords = sprintf('%s,%s', $startX, $y);
        if (array_search($coords, $this->foundNumbers, true)) {
            return null;
        }
        $this->foundNumbers[] = $coords;

        $number = '';
        while(is_numeric($character = $this->getCharacterAtPos($startX, $y))) {
            $number .= $character;
            $startX++;
        }

        return (int) $number;
    }
}