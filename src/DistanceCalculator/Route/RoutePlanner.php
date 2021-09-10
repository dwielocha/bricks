<?php

declare(strict_types=1);

namespace Bricks\DistanceCalculator\Route;

use Bricks\DistanceCalculator\Gps\IGpsCoords;
use Generator;

final class RoutePlanner
{
    /**
     * Return collection of possible routes
     * 
     * @param IGpsCoords $origin 
     * @param IGpsCoords[] $destinations 
     * @return PossibleRoutes 
     */
    public function getPossibleRoutes(IGpsCoords $origin, array $destinations): PossibleRoutes
    {
        $coordinates = $destinations;
        array_unshift($coordinates, $origin);

        // TODO: add caching layer, without caching objects itself
        //$distanceMatrix = $this->getDistanceMatrix([$origin], $destinations);
        $distanceMatrix = $this->getDistanceMatrix($coordinates);

        $routePermutations = $this->getPermutations(
            array_keys(
                $distanceMatrix['rows'][0]['elements']
            )
        );

        $routes = [];

        foreach ($routePermutations as $permutation) {
            // If route does not start from origin, skip it!
            if ($permutation[0] !== 0) {
                continue;
            }

            $parts = [];

            for ($i = 0, $max = count($permutation) - 1; $i < $max; $i++) {
                $from = $permutation[$i];
                $to = $permutation[$i+1];

                $parts[] = new RoutePart(
                    $coordinates[$from],
                    $coordinates[$to],
                    (int) $distanceMatrix['rows'][$from]['elements'][$to]['distance']['value'],
                    (int) $distanceMatrix['rows'][$from]['elements'][$to]['duration']['value'],
                );
            }

            $routes[] = new Route($parts);
        }


        return new PossibleRoutes($routes);
    }

    public function getPermutations(array $elements): Generator
    {
        if (count($elements) <= 1) {
            yield $elements;
        } else {
            foreach ($this->getPermutations(array_slice($elements, 1)) as $permutation) {
                foreach (range(0, count($elements) - 1) as $i) {
                    yield array_merge(
                        array_slice($permutation, 0, $i),
                        [$elements[0]],
                        array_slice($permutation, $i)
                    );
                }
            }
        }
    }

    private function getDistanceMatrix(array $coordinates)
    {
        return [
            'status' => 'OK',
            'rows' => [
                [
                    'elements' => [
                        [
                            'distance' => [
                                'text' => '0 km',
                                'value' => 0,
                            ],
                            'duration' => [
                                'text' => '0 min',
                                'value' => 0,
                            ],
                            'status' => 'OK',
                        ],
                        [
                            'distance' => [
                                'text' => '2,7 km',
                                'value' => 2700,
                            ],
                            'duration' => [
                                'text' => '5 min',
                                'value' => 300,
                            ],
                            'status' => 'OK',
                        ],
                        // [
                        //     'distance' => [
                        //         'text' => '3 km',
                        //         'value' => 3000,
                        //     ],
                        //     'duration' => [
                        //         'text' => '5 min',
                        //         'value' => 200,
                        //     ],
                        //     'status' => 'OK',
                        // ],
                    ],
                ],
                [
                    'elements' => [
                        [
                            'distance' => [
                                'text' => '1,6 km',
                                'value' => 1633,
                            ],
                            'duration' => [
                                'text' => '5 min',
                                'value' => 291,
                            ],
                            'status' => 'OK',
                        ],
                        [
                            'distance' => [
                                'text' => '0 km',
                                'value' => 0,
                            ],
                            'duration' => [
                                'text' => '0 min',
                                'value' => 0,
                            ],
                            'status' => 'OK',
                        ],
                    ],
                ],
            ]
        ];
    }
}