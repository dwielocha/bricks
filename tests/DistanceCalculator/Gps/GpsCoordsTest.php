<?php 

declare(strict_types=1);

namespace Tests\DistanceCalculator\Gps;

use Bricks\DistanceCalculator\Gps\GpsCoords;
use PHPUnit\Framework\TestCase;
use InvalidArgumentException;

final class GpsCoordsTest extends TestCase
{
    /**
     * Data provider: valid GPS coordinates.
     * 
     * @return array 
     */
    public function validCoordinatesDataProvider(): array
    {
        return [
            [-90, -180],
            [-90, 180],
            [90, -180],
            [90, 180],
            [0, 0],
            [-80.234, -150.1234],
            [-80.234, 150.1234],
            [80.234, -150.1234],
            [80.234, 150.1234],
        ];
    }

    /**
     * Data provider: invalid GPS coordinates.
     * 
     * @return array 
     */
    public function invalidCoordinatesDataProvider(): array
    {
        return [
            // both params invalid
            [-90.001, -180.001],
            [90.001, -180.001],

            // invalid latitude
            [-90.001, -179.999],
            [-90.001, 179.999],
            [90.001, -179.999],
            [90.001, 179.999],

            // invalid longitude
            [-89.999, -180.001],
            [-89.999, 180.001],
            [89.999, -180.001],
            [89.999, 180.001],
        ];
    }

    /**
     * @test
     * @dataProvider validCoordinatesDataProvider
     * 
     * @param float $latitude 
     * @param float $longitude 
     */
    public function GpsCoordsObjectShouldBeCreatedForValidCoordinates(float $latitude, float $longitude): void
    {
        $this->assertInstanceOf(
            GpsCoords::class,
            new GpsCoords($latitude, $longitude)
        );
    }

    /**
     * @test
     * @dataProvider invalidCoordinatesDataProvider
     * 
     * @param float $latitude 
     * @param float $longitude 
     */
    public function InvalidArgumentExceptionShouldBeThrownForInvalidCoordinates(float $latitude, float $longitude): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Invalid input coordinates: {$latitude},{$longitude}");

        new GpsCoords($latitude, $longitude);
    }

    /**
     * @test
     */
    public function AValidLatitudeAndLongitudeShouldBeReturnedWhenGpsCoordsIsCreated(): void
    {
        /**
         * Arrange.
         */
        $latitude = 50.456;
        $longitude = 148.123;

        /**
         * Act.
         */
        $coordinates = new GpsCoords($latitude, $longitude);

        /**
         * Assert.
         */
        $this->assertSame($latitude, $coordinates->getLatitude());
        $this->assertSame($longitude, $coordinates->getLongitude());
    }
}
