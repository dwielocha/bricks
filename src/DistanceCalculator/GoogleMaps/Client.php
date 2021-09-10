<?php

declare(strict_types=1);

namespace Bricks\DistanceCalculator\GoogleMaps;

use Bricks\DistanceCalculator\Gps\IGpsCoords;
use Bricks\DistanceCalculator\Route\PossibleRoutes;
use Bricks\DistanceCalculator\Route\Route;
use Bricks\DistanceCalculator\Route\RoutePart;
use Exception;
use GuzzleHttp\ClientInterface;

/**
 * Google Maps API Client
 */
final class Client
{
    private const API_URL = 'https://maps.googleapis.com/maps/api/distancematrix/json';

    private $httpClient;
    private $apiKey;

    public function __construct(ClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
        $this->apiKey = getenv('GOOGLE_MAPS_API_DISTANCE_MATRIX_KEY');
    }

    public function getDistanceMatrix(array $origins, array $destinations): array
    {
        $origins = [];
        $destinations = [];

        $queryParams = [
            'mode' => 'driving',
            'origins' => $this->buildMultipleCoordinatesString($origins),
            'destinations' => $this->buildMultipleCoordinatesString($destinations),
            'key' => $this->apiKey,
        ];

        $response = $this->httpClient->request(
            'GET',
            self::API_URL,
            ['query' => $queryParams]
        );

        if ($response === null || $response->getStatusCode() !== 200) {
            throw new Exception();
        }

        $content = $response->getBody()->getContents();
        $data = json_decode($content, true);

        if ($data['status'] !== 'OK' || !isset($data['rows'])) {
            throw new Exception('Invalid response from Google Maps!');
        }

        // return distance matrix
        return $data['rows'];
    }

    /**
     * Build multiple coordinates string
     * e.g. "45.482772,9.213982|46.234345,7.756456"
     *
     * @param IGpsCoords[] $coordinates
     *
     * @return string
     */
    private function buildMultipleCoordinatesString(array $coordinates): string
    {
        $coordinatesList = [];

        foreach ($coordinates as $coords) {
            $coordinatesList[] = $coords->getLatitude().','.$coords->getLongitude();
        }

        return implode('|', $coordinatesList);
    }

    /**
     * Return collection of possible routes
     * 
     * @param IGpsCoords $origin 
     * @param IGpsCoords[] $destinations 
     * @return PossibleRoutes 
     */
    public function getPossibleRoutes(IGpsCoords $origin, array $destinations): PossibleRoutes
    {
        // TODO: add caching layer, without caching objects itself
        $distanceMatrix = $this->getDistanceMatrix([$origin], $destinations);


        $routes = [
            new Route(
                [
                    new RoutePart(
                        $origin,
                        $destinations[0],
                        50,
                        100
                    )
                ]
            )
        ];

        return new PossibleRoutes($routes);
    }
}
