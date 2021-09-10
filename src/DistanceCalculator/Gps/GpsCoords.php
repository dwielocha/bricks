<?php

declare(strict_types=1);

namespace Bricks\DistanceCalculator\Gps;

use InvalidArgumentException;

/**
 * A class that represents GPS Coordinates.
 */
final class GpsCoords implements IGpsCoords
{
    private float $latitude;
    private float $longitude;

    /**
     * Constructor.
     */
    public function __construct(float $latitude, float $longitude)
    {
        if ($latitude < -90.0
            || $latitude > 90.0
            || $longitude < -180.0
            || $longitude > 180.0
        ) {
            throw new InvalidArgumentException(
                "Invalid input coordinates: {$latitude},{$longitude}"
            );
        }

        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    public function getLatitude(): float
    {
        return $this->latitude;
    }

    public function getLongitude(): float
    {
        return $this->longitude;
    }
}
