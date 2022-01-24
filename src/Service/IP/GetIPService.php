<?php

namespace App\Service\IP;

use App\Entity\IPAddress;

class GetIPService
{
    public function execute(): IPAddress
    {
        $ip = new IPAddress();
        $ip->setIp(file_get_contents('https://ipecho.net/plain'));

        return $ip;
    }
}