<?php

declare(strict_types=1);

readonly class Range
{
    public function __construct(
        private int $destinationStart,
        private int $sourceStart,
        private int $length,
    ) {
    }

    public function contains(int $source): bool
    {
        return $source >= $this->sourceStart && $source <= $this->sourceStart + $this->length;
    }

    public function getDestination(int $source): int
    {
        if (!$this->contains($source)) {
            throw new RuntimeException('Source not in range');
        }

        $difference = $source - $this->sourceStart;
        return $this->destinationStart + $difference;
    }
}
