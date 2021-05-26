<?php

namespace App\Entity;

use App\Repository\CountryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CountryRepository::class)
 */
class Country
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $label;

    /**
     * @ORM\OneToMany(targetEntity=Client::class, mappedBy="country")
     */
    private $clients;

    /**
     * @ORM\OneToMany(targetEntity=RelayPoint::class, mappedBy="country", orphanRemoval=true)
     */
    private $relayPoints;

    public function __construct()
    {
        $this->clients = new ArrayCollection();
        $this->relayPoints = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return Collection|Client[]
     */
    public function getClients(): Collection
    {
        return $this->clients;
    }

    public function addClient(Client $client): self
    {
        if (!$this->clients->contains($client)) {
            $this->clients[] = $client;
            $client->setCountry($this);
        }

        return $this;
    }

    public function removeClient(Client $client): self
    {
        if ($this->clients->removeElement($client)) {
            // set the owning side to null (unless already changed)
            if ($client->getCountry() === $this) {
                $client->setCountry(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|RelayPoint[]
     */
    public function getRelayPoints(): Collection
    {
        return $this->relayPoints;
    }

    public function addRelayPoint(RelayPoint $relayPoint): self
    {
        if (!$this->relayPoints->contains($relayPoint)) {
            $this->relayPoints[] = $relayPoint;
            $relayPoint->setCountry($this);
        }

        return $this;
    }

    public function removeRelayPoint(RelayPoint $relayPoint): self
    {
        if ($this->relayPoints->removeElement($relayPoint)) {
            // set the owning side to null (unless already changed)
            if ($relayPoint->getCountry() === $this) {
                $relayPoint->setCountry(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->label;
    }
    
}
