<?php

declare(strict_types=1);

namespace Bricks\DistanceCalculator;

use Bricks\DistanceCalculator\Gps\IGpsCoords;

use function asin;
use function cos;
use function deg2rad;
use function pow;
use function round;
use function sin;
use function sqrt;

/**
 * Distance calculator using haversine method.
 */
final class HaversineDistanceCalculator
{
    public function getDistance(
        IGpsCoords $origin,
        IGpsCoords $destination
    ): int {
        // convert from degrees to radians
        $latitudeA = deg2rad($origin->getLatitude());
        $longitudeA = deg2rad($origin->getLongitude());
        $latitudeB = deg2rad($destination->getLatitude());
        $longitudeB = deg2rad($destination->getLongitude());

        $latitudeDelta = $latitudeB - $latitudeA;
        $longitudeDelta = $longitudeB - $longitudeA;

        $angle = 2 * asin(sqrt(pow(sin($latitudeDelta / 2), 2) +
            cos($latitudeA) * cos($latitudeB) * pow(sin($longitudeDelta / 2), 2)));

        // result in metres
        return (int) round($angle * 6371000);
    }
}
