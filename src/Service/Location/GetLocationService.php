<?php

namespace App\Service\Location;


use App\Entity\IPAddress;
use App\Entity\Location;
use App\Repository\Location\LiveLocationRepositoryInterface;
use App\Repository\Location\LocationRepository;
use App\Service\IP\GetIPService;

class GetLocationService
{
    public function __construct(
        private LiveLocationRepositoryInterface $liveRepository,
        private LocationRepository $repository
    ) {
    }

    public function execute(IPAddress $ip): Location
    {
        return $this->liveRepository->findByIPAddress($ip);
    }
}