<?php

declare(strict_types=1);

namespace Bricks\DistanceCalculator\Route;

use Bricks\DistanceCalculator\Gps\IGpsCoords;

final class RoutePart
{
    private $origin;
    private $destination;
    private $distance;
    private $duration;

    public function __construct(
        IGpsCoords $origin, 
        IGpsCoords $destination, 
        int $distance, 
        int $duration
    ) {
        $this->origin = $origin;
        $this->destination = $destination;
        $this->distance = $distance;
        $this->duration = $duration;
    }

    public function getOrigin(): IGpsCoords
    {
        return $this->origin;
    }

    public function getDestination(): IGpsCoords
    {
        return $this->destination;
    }

    public function getDistance(): int
    {
        return $this->distance;
    }

    public function getDuration(): int
    {
        return $this->duration;
    }
}
