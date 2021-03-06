<?php

namespace App\Entity;

use App\Repository\Weather\WeatherRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WeatherRepository::class)]
class Weather
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 50)]
    private $main;

    #[ORM\Column(type: 'string', length: 100)]
    private $description;

    #[ORM\Column(type: 'integer')]
    private $temperature;

    #[ORM\Column(type: 'integer')]
    private $feels_like;

    #[ORM\Column(type: 'integer')]
    private $pressure;

    #[ORM\Column(type: 'integer')]
    private $humidity;

    #[ORM\Column(type: 'integer')]
    private $wind_speed;

    #[ORM\Column(type: 'integer')]
    private $clouds;

    #[ORM\OneToOne(mappedBy: 'weather', targetEntity: Location::class, cascade: ['persist', 'remove'])]
    private $location;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMain(): ?string
    {
        return $this->main;
    }

    public function setMain(string $main): self
    {
        $this->main = $main;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getTemperature(): ?float
    {
        return $this->temperature / 100;
    }

    public function setTemperature(int $temperature): self
    {
        $this->temperature = $temperature;

        return $this;
    }

    public function getFeelsLike(): ?float
    {
        return $this->feels_like / 100;
    }

    public function setFeelsLike(int $feels_like): self
    {
        $this->feels_like = $feels_like;

        return $this;
    }

    public function getPressure(): ?int
    {
        return $this->pressure;
    }

    public function setPressure(int $pressure): self
    {
        $this->pressure = $pressure;

        return $this;
    }

    public function getHumidity(): ?int
    {
        return $this->humidity;
    }

    public function setHumidity(int $humidity): self
    {
        $this->humidity = $humidity;

        return $this;
    }

    public function getWindSpeed(): ?float
    {
        return $this->wind_speed / 100;
    }

    public function setWindSpeed(int $wind_speed): self
    {
        $this->wind_speed = $wind_speed;

        return $this;
    }

    public function getClouds(): ?int
    {
        return $this->clouds;
    }

    public function setClouds(int $clouds): self
    {
        $this->clouds = $clouds;

        return $this;
    }

    public function getLocation(): ?Location
    {
        return $this->location;
    }

    public function setLocation(Location $location): self
    {
        // set the owning side of the relation if necessary
        if ($location->getWeather() !== $this) {
            $location->setWeather($this);
        }

        $this->location = $location;

        return $this;
    }
}
