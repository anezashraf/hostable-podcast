<?php

namespace App\Entity;

use DateInterval;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\InvitationLinkRepository")
 */
class InvitationLink
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", cascade={"persist", "remove"})
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=48)
     */
    private $link;

    /**
     * @ORM\Column(type="datetime")
     */
    private $expiryDate;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $used;


    private $invitationLink;

    public function __construct(string $invitationLink)
    {
        $this->link = $invitationLink;
        $this->expiryDate =  new DateTime('now +1 day'); //Tomorrow
        //$new_time = $now->format('Y-m-d H:i:s');
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getLink(): ?string
    {
        return $this->Link;
    }

    public function setLink(string $Link): self
    {
        $this->Link = $Link;

        return $this;
    }

    public function getExpiryDate(): ?\DateTimeInterface
    {
        return $this->ExpiryDate;
    }

    public function setExpiryDate(\DateTimeInterface $ExpiryDate): self
    {
        $this->ExpiryDate = $ExpiryDate;

        return $this;
    }

    public function getUsed(): ?bool
    {
        return $this->Used;
    }

    public function setUsed(bool $Used): self
    {
        $this->used = $Used;

        return $this;
    }
}
