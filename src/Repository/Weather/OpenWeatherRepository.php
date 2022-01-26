<?php

namespace App\Repository\Weather;

use App\Entity\Location;
use App\Entity\Weather;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class OpenWeatherRepository implements LiveWeatherRepositoryInterface
{
    public function __construct(
        private HttpClientInterface $client,
        private string              $appId
    )
    {
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

        if ($content->cod !== 200) {
            $content->provider = 'api.openweathermap.org';
            throw new BadRequestException(json_encode($content));
        }

        $weather = new Weather();
        $weather
            ->setMain($content->weather[0]->main)
            ->setDescription($content->weather[0]->description)
            ->setTemperature($content->main->temp * 100)
            ->setFeelsLike($content->main->feels_like * 100)
            ->setPressure($content->main->pressure)
            ->setHumidity($content->main->humidity)
            ->setClouds($content->clouds->all)
            ->setWindSpeed($content->wind->speed * 100);

        return $weather;
    }
}