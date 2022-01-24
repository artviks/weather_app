<?php

namespace App\Repository\Weather;

use App\Entity\Location;
use App\Entity\Weather;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class OpenWeatherRepository implements LiveWeatherRepositoryInterface
{
    public function __construct(
        private HttpClientInterface $client,
        private string $appId
    ) {
    }

    public function findByLocation(Location $location): Weather
    {
        $response = $this->client->request(
            'GET',
            "https://api.openweathermap.org/data/2.5/weather",
            [
                'query' => [
                    'units' => 'metric',
                    'q' => $location->getCity(),
                    'appid' => $this->appId
                ]
            ]
        );

        $content = json_decode($response->getContent(), false);

        $weather = new Weather();
        $weather->setMain($content->weather[0]->main);
        $weather->setDescription($content->weather[0]->description);
        $weather->setTemperature($content->main->temp * 100);
        $weather->setFeelsLike($content->main->feels_like * 100);
        $weather->setPressure($content->main->pressure);
        $weather->setHumidity($content->main->humidity);
        $weather->setClouds($content->clouds->all);
        $weather->setWindSpeed($content->wind->speed * 100);

        return $weather;
    }
}