<?php

namespace App\Service\Weather;

use App\Entity\Location;
use App\Entity\Weather;
use App\Repository\Weather\LiveWeatherRepositoryInterface;
use App\Repository\Weather\WeatherRepository;
use App\Service\IP\GetIPService;
use App\Service\Location\GetLocationService;
use Doctrine\Persistence\ManagerRegistry;

class GetWeatherService
{
    public function __construct(
        private GetLocationService $getLocation,
        private LiveWeatherRepositoryInterface $liveRepository,
        private ManagerRegistry $doctrine
    ) {
    }

    public function execute(): Weather
    {
        $location = $this->getLocation->execute();

        if ($location->getWeather()) {
            return $location->getWeather();
        }

        $weather = $this->liveRepository->findByLocation($location);
        $weather->setLocation($location);
        $entityManager = $this->doctrine->getManager();
        $entityManager->persist($weather);
        $entityManager->flush();

        return $weather;
    }
}