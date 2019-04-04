<?php

namespace App\Entity;

use App\Entity\Common\IdTrait;
use App\Entity\Common\TimestampTrait;
use App\Entity\Contracts\EntityInterface;
use DateInterval;
use DateTime;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass="App\Repository\InvitationLinkRepository")
 *
 * @ORM\HasLifecycleCallbacks()
 */
class InvitationLink implements EntityInterface
{

    use IdTrait;
    use TimestampTrait;

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


    public function __construct(string $invitationLink)
    {
        $this->link = $invitationLink;
        $this->expiryDate =  new DateTime('now +1 day');
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
        return $this->link;
    }

    public function setLink(string $link): self
    {
        $this->link = $link;

        return $this;
    }

    public function getExpiryDate(): ?DateTimeInterface
    {
        return $this->expiryDate;
    }

    public function setExpiryDate(DateTimeInterface $expiryDate): self
    {
        $this->expiryDate = $expiryDate;

        return $this;
    }

    public function getUsed(): ?bool
    {
        return $this->used;
    }

    public function setUsed(bool $used): self
    {
        $this->used = $used;

        return $this;
    }
}
