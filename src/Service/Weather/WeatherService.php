<?php

namespace App\Service\Weather;

use App\Entity\Location;
use App\Entity\Weather;
use App\Repository\Weather\LiveWeatherRepositoryInterface;
use App\Service\Location\LocationService;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Contracts\Cache\ItemInterface;

class WeatherService
{
    private Location $location;
    private ObjectManager $entityManager;

    public function __construct(
        LocationService                        $locationService,
        private LiveWeatherRepositoryInterface $liveRepository,
        private AdapterInterface               $cache,
        ManagerRegistry                        $doctrine
    )
    {
        $this->location = $locationService->fetch();
        $this->entityManager = $doctrine->getManager();
    }

    public function fetch(): Weather
    {
        return $this->cache->get(
            $this->location->getCity(),
            function (ItemInterface $item) {
                $item->expiresAfter(10);

                if ($this->location->getWeather()) {
                    return $this->location->getWeather();
                }

                return $this->fetchAndSaveFresh();
            });
    }

    public function update(): Weather
    {
        $id = $this->location->getWeather()?->getId();
        $weather = $this->entityManager->getRepository(Weather::class)->find($id);

        if (!$weather) {
            return $this->fetchAndSaveFresh();
        }

        $updatedWeather = $this->liveRepository->findByLocation($this->location);

        $weather
            ->setMain($updatedWeather->getMain())
            ->setDescription($updatedWeather->getDescription())
            ->setTemperature($updatedWeather->getTemperature() * 100)
            ->setFeelsLike($updatedWeather->getFeelsLike() * 100)
            ->setPressure($updatedWeather->getPressure())
            ->setHumidity($updatedWeather->getHumidity())
            ->setClouds($updatedWeather->getClouds())
            ->setWindSpeed($updatedWeather->getWindSpeed() * 100);

        $this->entityManager->persist($weather);
        $this->entityManager->flush();

        return $weather;
    }

    private function fetchAndSaveFresh(): Weather
    {
        $weather = $this->liveRepository->findByLocation($this->location);
        $weather->setLocation($this->location);

        $this->entityManager->persist($weather);
        $this->entityManager->flush();

        return $weather;
    }
}