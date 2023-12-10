<?php

declare(strict_types=1);

class Map
{
    /**
     * @var array<Range>
     */
    private array $map;

    public function addRange(int $destination, int $source, int $length): void
    {
        $this->map[] = new Range($destination, $source, $length);
    }

    public function getDestination(int $source): int
    {
        foreach ($this->map as $range) {
            if (!$range->contains($source)) {
                continue;
            }

            return $range->getDestination($source);
        }

        return $source;
    }
}
