<?php

namespace App\Repository\Location;

use App\Entity\IPAddress;
use App\Entity\Location;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class IPStackLocationRepository implements LiveLocationRepositoryInterface
{
    public function __construct(
        private HttpClientInterface $client,
        public string $accessKey
    ){

    }

    public function findByIPAddress(IPAddress $ip): Location
    {
//        $response = $this->client->request(
//            'GET',
//            "http://api.ipstack.com/{$ip->getIp()}?access_key={$this->accessKey}"
//        );
//        $content = json_decode($response->getContent(), false);

        // for local dev
        $content = json_decode(file_get_contents('C:/laragon/www/tet/response.json'));

        $location = new Location();
        $location->setContinentCode($content->continent_code);
        $location->setContinentName($content->continent_name);
        $location->setCountryCode($content->country_code);
        $location->setCountryName($content->country_name);
        $location->setCity($content->city);
        $location->setZip($content->zip);

        return $location;
    }
}