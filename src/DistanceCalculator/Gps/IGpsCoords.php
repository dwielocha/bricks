<?php

declare(strict_types=1);

namespace Bricks\DistanceCalculator\Gps;

/**
 * Interface for GPS Coordinates data
 */
interface IGpsCoords
{
    public function getLatitude(): float;

    public function getLongitude(): float;
}
