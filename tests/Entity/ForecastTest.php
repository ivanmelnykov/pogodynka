<?php

namespace App\Tests\Entity;

use App\Entity\Forecast;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

class ForecastTest extends TestCase
{

    public static function dataGetFahrenheit(): array
    {
        return [
            ['0', '32'],
            ['-100', '-148'],
            ['100', '212'],
            ['0.5', '32.9'],
            ['-0.5', '31.1'],
            ['10', '50'],
            ['-10', '14'],
            ['20', '68'],
            ['-40', '-40'],
            ['37.5', '99.5'],
        ];
    }


    #[DataProvider('dataGetFahrenheit')]
    public function testGetFahrenheit(string $celsius, string $expectedFahrenheit): void
    {
        $forecast = new Forecast();


        $forecast->setTemperature((float) $celsius);


        $this->assertEquals((float) $expectedFahrenheit, $forecast->getFahrenheit());
    }
}
