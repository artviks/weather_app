<?php

namespace App\Repository\Location;

use App\Entity\IPAddress;
use App\Entity\Location;

interface LiveLocationRepositoryInterface
{
    public function findByIPAddress(IPAddress $ip): Location;
}