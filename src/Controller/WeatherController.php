<?php

namespace App\Controller;

use App\Service\IP\GetIPService;
use App\Service\Location\GetLocationService;
use App\Service\Weather\GetWeatherService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class WeatherController extends AbstractController
{
    private Serializer $serializer;

    public function __construct()
    {
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $this->serializer = new Serializer($normalizers, $encoders);
    }

    #[Route('/', name: 'home')]
    public function index(
        GetLocationService $getLocation,
        GetIPService $getIP,
        GetWeatherService $getWeather
    ): Response
    {
        $ip = $getIP->execute();
        $location = $getLocation->execute($ip);
        $weather = $getWeather->execute($location);

        return new Response(
            $this->serializer->serialize($weather, 'json')
        );
    }
}
