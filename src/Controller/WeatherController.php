<?php

namespace App\Controller;


use App\Service\Json\JsonSerializer;
use App\Service\Weather\GetWeatherService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WeatherController extends AbstractController
{
    public function __construct(private JsonSerializer $serializer)
    {
    }

    #[Route('/', name: 'home')]
    public function index(GetWeatherService $getWeather): Response
    {
        $weather = $getWeather->execute();

        return new Response(
            $this->serializer->execute($weather),
            200,
            ['Content-Type' => 'application/json']
        );
    }
}
