<?php

namespace App\Service\Location;


use App\Entity\Location;
use App\Repository\Location\LiveLocationRepositoryInterface;
use App\Service\IP\GetIPService;
use Doctrine\Persistence\ManagerRegistry;

class GetLocationService
{
    public function __construct(
        private GetIPService $getIP,
        private LiveLocationRepositoryInterface $liveRepository,
        private ManagerRegistry $doctrine
    ) {
    }

    public function execute(): Location
    {
        $ip = $this->getIP->execute();

        if ($ip->getLocation()) {
            return $ip->getLocation();
        }

        $location = $this->liveRepository->findByIPAddress($ip);
        $location->addIPAddress($ip);

        $entityManager = $this->doctrine->getManager();
        $entityManager->persist($location);
        $entityManager->flush();

        return $location;
    }
}