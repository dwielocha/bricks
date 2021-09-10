<?php 

declare(strict_types=1);

namespace Tests\DistanceCalculator;

use Bricks\DistanceCalculator\Gps\GpsCoords;
use Bricks\DistanceCalculator\HaversineDistanceCalculator;
use PHPUnit\Framework\TestCase;

final class HaversineDistanceCalculatorTest extends TestCase
{
    /**
     * @test
     */
    public function AValidDistanceShouldBeReturnedWhen2CoordinatesWereGiven(): void
    {
        /**
         * Arrange.
         */
        $portaNuovaVerona = new GpsCoords(
            45.4314586,
            10.9882697
        );

        $arenaDiVerona = new GpsCoords(
            45.4384736,
            10.9920205
        );

        $realDistanceInMetres = 833;

        /**
         * Act.
         */
        $distanceCalculator = new HaversineDistanceCalculator();
        $distanceInMetres = $distanceCalculator->getDistance($portaNuovaVerona, $arenaDiVerona);

        /**
         * Assert.
         */
        $this->assertSame($realDistanceInMetres, $distanceInMetres);
    }
}
