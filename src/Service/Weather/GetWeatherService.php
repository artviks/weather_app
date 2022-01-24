<?php

namespace App\Service\Weather;

use App\Entity\Location;
use App\Entity\Weather;
use App\Repository\Weather\LiveWeatherRepositoryInterface;
use App\Repository\Weather\WeatherRepository;

class GetWeatherService
{
    public function __construct(
        private LiveWeatherRepositoryInterface $liveRepository,
        private WeatherRepository $repository
    ) {
    }

    public function execute(Location $location): Weather
    {
        return $this->liveRepository->findByLocation($location);
    }
}