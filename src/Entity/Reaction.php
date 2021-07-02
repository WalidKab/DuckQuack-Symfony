<?php

namespace App\Entity;

use App\Repository\ReactionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReactionRepository::class)
 */
class Reaction
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=AvailableReaction::class, inversedBy="reactions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $availableReaction;

    /**
     * @ORM\ManyToOne(targetEntity=Quack::class, inversedBy="reactions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $quack;

    /**
     * @ORM\ManyToOne(targetEntity=Duck::class, inversedBy="reactions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $duck;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAvailableReaction(): ?AvailableReaction
    {
        return $this->availableReaction;
    }

    public function setAvailableReaction(?AvailableReaction $availableReaction): self
    {
        $this->availableReaction = $availableReaction;

        return $this;
    }

    public function getQuack(): ?Quack
    {
        return $this->quack;
    }

    public function setQuack(?Quack $quack): self
    {
        $this->quack = $quack;

        return $this;
    }

    public function getDuck(): ?Duck
    {
        return $this->duck;
    }

    public function setDuck(?Duck $duck): self
    {
        $this->duck = $duck;

        return $this;
    }
}
