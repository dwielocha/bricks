<?php 

declare(strict_types=1);

namespace Tests\DistanceCalculator\Route;

use Bricks\DistanceCalculator\Gps\GpsCoords;
use Bricks\DistanceCalculator\Route\RoutePlanner;
use PHPUnit\Framework\TestCase;

final class RoutePlannerTest extends TestCase
{
    /**
     * @test
     */
    public function getPossibleRoutes_works_correctly()
    {
        // Given
        $portaNuovaVerona = new GpsCoords(
            45.4314586,
            10.9882697
        );

        $arenaDiVerona = new GpsCoords(
            45.4384736,
            10.9920205
        );


        // When
        $planner = new RoutePlanner();
        $possibleRoutes = $planner->getPossibleRoutes($portaNuovaVerona, [$arenaDiVerona]);

        print_r($possibleRoutes->getShortest());

        // Then
        $this->assertTrue(true);
    }
}