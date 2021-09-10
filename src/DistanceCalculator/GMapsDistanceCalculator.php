<?php

declare(strict_types=1);

namespace Bricks\DistanceCalculator;

use Bricks\DistanceCalculator\GoogleMaps\Client;
use Bricks\DistanceCalculator\Gps\IGpsCoords;
use Bricks\DistanceCalculator\Route\Route;

/**
 * Distance calculator using Google Maps Directions Matrix API.
 */
final class GMapsDistanceCalculator
{
    private $gMapsClient;

    public function __construct(Client $gMapsClient)
    {
        $this->gMapsClient = $gMapsClient;
    }

    /**
     * Return distance (in metres) between 2 GPS coordinates
     *
     * @param IGpsCoords $origin
     * @param IGpsCoords $destination
     *
     * @return int 
     */
    public function getDistance(
        IGpsCoords $origin,
        IGpsCoords $destination
    ): int {
        return $this
            ->getShortestRoute($origin, [$destination])
            ->getTotalDistance();
    }

    /**
     * Return the shortest route (by distance) from $origin to $destinations
     * 
     * @param IGpsCoords $origin
     * @param IGpsCoords[] $destinations
     * 
     * @return Route
     */
    public function getShortestRoute(
        IGpsCoords $origin, 
        array $destinations
    ): Route {
        return $this->gMapsClient
            ->getPossibleRoutes($origin, $destinations)
            ->getShortest();
    }

    /**
     * Return the fastest route (by duration) from $origin to $destinations
     * 
     * @param IGpsCoords $origin
     * @param IGpsCoords[] $destinations
     * 
     * @return Route
     */
    public function getFastestRoute(
        IGpsCoords $origin, 
        array $destinations
    ): Route {
        return $this->gMapsClient
            ->getPossibleRoutes($origin, $destinations)
            ->getFastest();
    }
}