<?php

declare(strict_types=1);

namespace Bricks\DistanceCalculator\Route;

use InvalidArgumentException;

final class PossibleRoutes
{
    private $routes;

    public function __construct(array $routes)
    {
        if (empty($routes)) {
            throw new InvalidArgumentException("No possible routes.");
        }

        $this->routes = $routes;
    }

    /**
     * Return the shortest route from possible ones.
     *
     * @return Route 
     */
    public function getShortest(): Route
    {
        $shortestRoute = null;
        $shortestDistance = 0;

        /** @var Route $route */
        foreach ($this->routes as $route) {
            $distance = $route->getTotalDistance();

            if ($shortestRoute === null || $distance < $shortestDistance) {
                $shortestRoute = $route;
                $shortestDistance = $distance;
            }
        }

        return $shortestRoute;
    }

    /**
     * Return the fastest route from possible ones.
     *
     * @return Route 
     */
    public function getFastest(): Route
    {
        $fastestRoute = null;
        $fastestDuration = 0;

        /** @var Route $route */
        foreach ($this->routes as $route) {
            $duration = $route->getTotalDuration();

            if ($fastestRoute === null || $duration < $fastestDuration) {
                $fastestRoute = $route;
                $fastestDuration = $duration;
            }
        }

        return $fastestRoute;
    }
}
