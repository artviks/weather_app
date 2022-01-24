<?php

namespace App\Repository\Weather;

use App\Entity\Location;
use App\Entity\Weather;

interface LiveWeatherRepositoryInterface
{
    public function findByLocation(Location $location): Weather;
}