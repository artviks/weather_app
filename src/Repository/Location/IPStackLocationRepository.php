<?php

namespace App\Repository\Location;

use App\Entity\IPAddress;
use App\Entity\Location;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class IPStackLocationRepository implements LiveLocationRepositoryInterface
{
    public function __construct(
        private HttpClientInterface $client,
        public string               $accessKey
    )
    {
    }

    public function findByIPAddress(IPAddress $ip): Location
    {
        $response = $this->client->request(
            'GET',
            "http://api.ipstack.com/{$ip->getIp()}?access_key={$this->accessKey}"
        );
        $content = json_decode($response->getContent(), false);

        if (property_exists($content, 'success') && !$content->success) {
            $content->provider = 'api.ipstack.com';
            throw new BadRequestException(json_encode($content));
        }

        $location = new Location();
        $location->setContinentCode($content->continent_code);
        $location->setContinentName($content->continent_name);
        $location->setCountryCode($content->country_code);
        $location->setCountryName($content->country_name);
        $location->setCity($content->city);
        $location->addIPAddress($ip);

        return $location;
    }
}