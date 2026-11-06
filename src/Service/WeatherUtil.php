<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\Location;
use App\Entity\Forecast;
use App\Repository\LocationRepository;
use App\Repository\ForecastRepository;

class WeatherUtil
{
    public function __construct(
        private LocationRepository $locationRepository,
        private ForecastRepository $forecastRepository
    ) {}

    /**
     * @return Forecast[]
     */
    public function getWeatherForLocation(Location $location): array
    {

        return $this->forecastRepository->findBy(['location' => $location]);
    }

    /**
     * @return Forecast[]
     */
    public function getWeatherForCountryAndCity(string $countryCode, string $city): array
    {

        $location = $this->locationRepository->findOneBy([
            'country' => $countryCode,
            'name' => $city,
        ]);

        if (!$location) {
            return [];
        }

        return $this->getWeatherForLocation($location);
    }
}
