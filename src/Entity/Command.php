<?php

namespace App\Entity;

use App\Repository\CommandRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommandRepository::class)
 */
class Command
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $montant;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;


    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="commands")
     * @ORM\JoinColumn(nullable=false)
     */
    private $client;

    /**
     * @ORM\ManyToOne(targetEntity=Status::class, inversedBy="commands")
     * @ORM\JoinColumn(nullable=false)
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity=PaymentMode::class, inversedBy="commands")
     * @ORM\JoinColumn(nullable=false)
     */
    private $paymentMode;

    /**
     * @ORM\ManyToOne(targetEntity=RelayPoint::class, inversedBy="commands")
     * @ORM\JoinColumn(nullable=true)
     */
    private $relaypoint;

    /**
     * @ORM\ManyToOne(targetEntity=DeliverMode::class, inversedBy="command")
     * @ORM\JoinColumn(nullable=false)
     */
    private $deliverMode;

    /**
     * @ORM\OneToMany(targetEntity=CommandProduct::class, mappedBy="command")
     */
    private $commandProducts;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->historique = new ArrayCollection();
        $this->commandProducts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMontant(): ?float
    {
        return $this->montant;
    }

    public function setMontant(float $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getStatus(): ?Status
    {
        return $this->status;
    }

    public function setStatus(?Status $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getPaymentMode(): ?PaymentMode
    {
        return $this->paymentMode;
    }

    public function setPaymentMode(?PaymentMode $paymentMode): self
    {
        $this->paymentMode = $paymentMode;

        return $this;
    }

    public function getRelaypoint(): ?RelayPoint
    {
        return $this->relaypoint;
    }

    public function setRelaypoint(?RelayPoint $relaypoint): self
    {
        $this->relaypoint = $relaypoint;

        return $this;
    }

    public function getDeliverMode(): ?DeliverMode
    {
        return $this->deliverMode;
    }

    public function setDeliverMode(?DeliverMode $deliverMode): self
    {
        $this->deliverMode = $deliverMode;

        return $this;
    }

    /**
     * @return Collection|CommandProduct[]
     */
    public function getCommandProducts(): Collection
    {
        return $this->commandProducts;
    }

    public function addCommandProduct(CommandProduct $commandProduct): self
    {
        if (!$this->commandProducts->contains($commandProduct)) {
            $this->commandProducts[] = $commandProduct;
            $commandProduct->setCommand($this);
        }

        return $this;
    }

    public function removeCommandProduct(CommandProduct $commandProduct): self
    {
        if ($this->commandProducts->removeElement($commandProduct)) {
            // set the owning side to null (unless already changed)
            if ($commandProduct->getCommand() === $this) {
                $commandProduct->setCommand(null);
            }
        }

        return $this;
    }
}
