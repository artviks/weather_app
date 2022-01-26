<?php

namespace App\Service\Location;

use App\Entity\IPAddress;
use App\Entity\Location;
use App\Repository\Location\LiveLocationRepositoryInterface;
use App\Service\IP\IPService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Contracts\Cache\ItemInterface;

class LocationService
{
    public function __construct(
        private IPService                       $IPService,
        private LiveLocationRepositoryInterface $liveRepository,
        private AdapterInterface                $cache,
        private ManagerRegistry                 $doctrine
    )
    {
    }

    public function fetch(): Location
    {
        $ip = $this->IPService->execute();

        return $this->cache->get(
            $ip->getIp(),
            function (ItemInterface $item) use ($ip) {
                $item->expiresAfter(10);

                return $this->fetchLocation($ip);
            });
    }

    private function fetchLocation(IPAddress $ip): Location
    {
        if ($ip->getLocation()) {
            return $ip->getLocation();
        }

        $entityManager = $this->doctrine->getManager();

        $location = $this->liveRepository->findByIPAddress($ip);
        $dbLocation = $this->doctrine
            ->getRepository(Location::class)
            ->findOneBy([
                'country_code' => $location->getCountryCode(),
                'city' => $location->getCity()
            ]);

        if ($dbLocation) {
            $dbLocation->addIPAddress($ip);
            $entityManager->persist($dbLocation);
            $entityManager->flush();

            return $dbLocation;
        }

        $entityManager->persist($location);
        $entityManager->flush();

        return $location;
    }
}