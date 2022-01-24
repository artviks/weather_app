<?php

namespace App\Entity;

use App\Repository\Location\LocationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LocationRepository::class)]
class Location
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 2)]
    private $continent_code;

    #[ORM\Column(type: 'string', length: 25)]
    private $continent_name;

    #[ORM\Column(type: 'string', length: 2)]
    private $country_code;

    #[ORM\Column(type: 'string', length: 50)]
    private $country_name;

    #[ORM\Column(type: 'string', length: 50)]
    private $city;

    #[ORM\Column(type: 'string', length: 50)]
    private $zip;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContinentCode(): ?string
    {
        return $this->continent_code;
    }

    public function setContinentCode(string $continent_code): self
    {
        $this->continent_code = $continent_code;

        return $this;
    }

    public function getContinentName(): ?string
    {
        return $this->continent_name;
    }

    public function setContinentName(string $continent_name): self
    {
        $this->continent_name = $continent_name;

        return $this;
    }

    public function getCountryCode(): ?string
    {
        return $this->country_code;
    }

    public function setCountryCode(string $country_code): self
    {
        $this->country_code = $country_code;

        return $this;
    }

    public function getCountryName(): ?string
    {
        return $this->country_name;
    }

    public function setCountryName(string $country_name): self
    {
        $this->country_name = $country_name;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getZip(): ?string
    {
        return $this->zip;
    }

    public function setZip(string $zip): self
    {
        $this->zip = $zip;

        return $this;
    }
}