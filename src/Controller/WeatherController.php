<?php

namespace App\Controller;

use App\Service\Json\JsonSerializer;
use App\Service\Weather\WeatherService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WeatherController extends AbstractController
{
    public function __construct(
        private JsonSerializer $serializer,
        private WeatherService $weatherService
    )
    {
    }

    #[Route('/', name: 'home')]
    public function index(): Response
    {
        $weather = $this->weatherService->fetch();

        return new Response(
            $this->serializer->execute($weather),
            200,
            ['Content-Type' => 'application/json']
        );
    }

    #[Route('/update', name: 'update')]
    public function update(): Response
    {
        $weather = $this->weatherService->update();

        return new Response(
            $this->serializer->execute($weather),
            200,
            ['Content-Type' => 'application/json']
        );
    }
}
