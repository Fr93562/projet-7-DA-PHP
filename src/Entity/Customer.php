<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CustomerRepository")
 */
class Customer
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $token;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateLimit;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function getDateLimit(): ?\DateTimeInterface
    {
        return $this->dateLimit;
    }

    public function setDateLimit(?\DateTimeInterface $dateLimit): self
    {
        $this->dateLimit = $dateLimit;

        return $this;
    }
    /*
    public function getDateLimit(): ?date
    {
        return $this->dateLimit;
    }

    public function setDateLimit(date $dateLimit): self
    {
        $this->dateLimit = $dateLimit;

        return $this;
    }
    */
}
