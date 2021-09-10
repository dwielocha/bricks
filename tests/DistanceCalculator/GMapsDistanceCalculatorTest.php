<?php 

declare(strict_types=1);

namespace Tests\DistanceCalculator;

use Bricks\DistanceCalculator\GMapsDistanceCalculator;
use Bricks\DistanceCalculator\GoogleMaps\Client;
use Bricks\DistanceCalculator\Gps\GpsCoords;
use PHPUnit\Framework\TestCase;

final class GMapsDistanceCalculatorTest extends TestCase
{
    /**
     * @test
     */
    public function AValidDistanceShouldBeReturnedWhen2CoordinatesWereGiven()
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

        $realDistanceInMetres = 833;

        // Then
        $client = new Client();
        $calculator = new GMapsDistanceCalculator($client);
        $distance = $calculator->getDistance($portaNuovaVerona, $arenaDiVerona);

        // When
        $this->assertSame($realDistanceInMetres, $distance);
    }
}
