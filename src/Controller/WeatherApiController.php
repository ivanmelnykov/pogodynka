<?php

namespace App\Controller;

use App\Entity\Forecast;
use App\Service\WeatherUtil;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;

class WeatherApiController extends AbstractController
{
    #[Route('/api/v1/weather', name: 'app_weather_api', methods: ['GET'])]
    public function index(
        #[MapQueryParameter] string $country,
        #[MapQueryParameter] string $city,
        WeatherUtil $weatherUtil,
        #[MapQueryParameter] string $format = 'json',
        #[MapQueryParameter('twig')] bool $twig = false
    ): Response {

        $forecasts = $weatherUtil->getWeatherForCountryAndCity($country, $city);

        if ($twig) {
            if ($format === 'csv') {
                return $this->render('weather_api/index.csv.twig', [
                    'city' => $city,
                    'country' => $country,
                    'forecasts' => $forecasts,
                ]);
            }

            return $this->render('weather_api/index.json.twig', [
                'city' => $city,
                'country' => $country,
                'forecasts' => $forecasts,
            ]);
        }



        if ($format === 'csv') {
            $csvLines = [];

            $csvLines[] = 'city,country,date,celsius,fahrenheit';

            foreach ($forecasts as $f) {
                $csvLines[] = sprintf(
                    '%s,%s,%s,%s,%s',
                    $city,
                    $country,
                    $f->getDate()->format('Y-m-d'),
                    $f->getTemperature(),
                    $f->getFahrenheit()
                );
            }

            $csvContent = implode("\n", $csvLines);

            return new Response($csvContent, 200, [
                'Content-Type' => 'text/plain; charset=utf-8'
            ]);
        }

        return $this->json([
            'city' => $city,
            'country' => $country,
            'forecasts' => array_map(fn(Forecast $f) => [
                'date' => $f->getDate()->format('Y-m-d'),
                'celsius' => $f->getTemperature(),
                'fahrenheit' => $f->getFahrenheit(),
            ], $forecasts),
        ]);
    }
}
