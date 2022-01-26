<?php

namespace App\Service\IP;

use App\Entity\IPAddress;
use App\Repository\IPAdressRepository;
use Doctrine\Persistence\ManagerRegistry;

class IPService
{
    public function __construct(
        private IPAdressRepository $repository,
        private ManagerRegistry    $doctrine
    )
    {
    }

    public function execute(): IPAddress
    {
        $ip = new IPAddress();
        $ip->setIp(file_get_contents('https://ipecho.net/plain'));

        $dbIP = $this->repository->findOneBy([
            'ip' => $ip->getIp()
        ]);

        if ($dbIP) {
            return $dbIP;
        }

        $entityManager = $this->doctrine->getManager();
        $entityManager->persist($ip);
        $entityManager->flush();

        return $ip;
    }
}