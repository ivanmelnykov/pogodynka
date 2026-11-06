<?php

namespace App\Command;

use App\Service\WeatherUtil;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Attribute\Argument;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'weather:city',
    description: 'Displays weather data for the current city and name.',
)]
class WeatherCityCommand extends Command
{
    public function __construct(
        private WeatherUtil $weatherUtil
    ) {
        parent::__construct();
    }

    public function __invoke(
        SymfonyStyle $io,
        #[Argument('Country code')] string $countryCode,
        #[Argument('City name')] string $cityName,
    ): int {

        $forecasts = $this->weatherUtil->getWeatherForCountryAndCity($countryCode, $cityName);

        if (empty($forecasts)) {
            $io->warning(sprintf('Lack of forecast for location%s (%s).', $cityName, $countryCode));
            return Command::SUCCESS;
        }

        $io->writeln(sprintf('Location: %s, %s', $cityName, $countryCode));


        $io->table(
            ['Date', 'Temperature', 'Wind', 'Humidity', 'Precipitation'],
            array_map(fn($f) => [
                $f->getDate()->format('Y-m-d'),
                $f->getTemperature() . '°C',
                $f->getWind() . ' km/h',
                $f->getHumidity() . '%',
                $f->getChanceOfPreticipation() . '%',
            ], $forecasts)
        );

        return Command::SUCCESS;
    }
}
