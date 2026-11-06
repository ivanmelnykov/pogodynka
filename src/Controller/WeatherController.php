<?php

namespace App\Controller;

use App\Entity\Location;
use App\Service\WeatherUtil;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class WeatherController extends AbstractController
{

    #[Route('/weather/{name}/{country}', name: 'app_weather', defaults: ['country' => null])]
    public function city(
        Location $location,
        WeatherUtil $util
    ): Response {


        $forecasts = $util->getWeatherForLocation($location);

        return $this->render('weather/name.html.twig', [
            'location' => $location,
            'forecasts' => $forecasts,
        ]);
    }
}
