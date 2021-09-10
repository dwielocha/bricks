<?php

declare(strict_types=1);

namespace Bricks\DistanceCalculator\Route;

final class Route
{
    private $parts;

    public function __construct(array $parts)
    {
        $this->parts = $parts;
    }

    public function getParts(): array
    {
        return $this->parts;
    }

    public function getTotalDistance(): int
    {
        $distance = 0;

        foreach ($this->parts as $part) {
            $distance += $part->getDistance();
        }

        return $distance;
    }

    public function getTotalDuration(): int
    {
        $duration = 0;

        foreach ($this->parts as $part) {
            $duration += $part->getDuration();
        }

        return $duration;
    }
}
