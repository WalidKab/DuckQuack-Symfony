<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommentRepository::class)
 */
class Comment
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
    private $content;

    /**
     * @ORM\Column(type="datetime")
     */
    private $posted_at;

    /**
     * @ORM\ManyToOne(targetEntity=Duck::class, inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $duck;

    /**
     * @ORM\ManyToOne(targetEntity=Quack::class, inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $quack;

    public function __construct(){
        $this->posted_at=new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getPostedAt(): ?\DateTime
    {
        return $this->posted_at;
    }

    public function setPostedAt(\DateTime $posted_at): self
    {
        $this->posted_at = $posted_at;

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

    public function getQuack(): ?Quack
    {
        return $this->quack;
    }

    public function setQuack(?Quack $quack): self
    {
        $this->quack = $quack;

        return $this;
    }
}