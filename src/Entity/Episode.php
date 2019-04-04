<?php

namespace App\Entity;

use App\Entity\Common\IdTrait;
use App\Entity\Common\TimestampTrait;
use App\Entity\Contracts\EntityInterface;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EpisodeRepository")
 *
 * @ORM\HasLifecycleCallbacks()
 */
class Episode implements EntityInterface
{

    use IdTrait;
    use TimestampTrait;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("dashboard")
     *
     *
     */
    private $title;

    /**
     * @Groups("dashboard")
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @Groups("dashboard")
     * @ORM\Column(type="text")
     */
    private $slug;


    /**
     * @Groups("dashboard")
     * @ORM\Column(type="datetime")
     */
    private $publishedAt;

    /**
     * @Groups("dashboard")
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Podcast", inversedBy="episodes", fetch="EAGER")
     * @ORM\JoinColumn(nullable=false)
     */
    private $podcast;

    /**
     *
     * @Groups("dashboard")

     * @Assert\File(
     *     mimeTypes={ "audio/mpeg" },
     *     maxSize="1000000M"
     * )
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $enclosureUrl;

    public function __construct()
    {
        $this->slug = uniqid();
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

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

    public function getPublishedAt(): ?DateTimeInterface
    {
        return $this->publishedAt;
    }

    public function setPublishedAt(DateTimeInterface $publishedAt): self
    {
        $this->publishedAt = $publishedAt;

        return $this;
    }

    public function getPodcast(): ?Podcast
    {
        return $this->podcast;
    }

    public function setPodcast(?Podcast $podcast): self
    {
        $this->podcast = $podcast;

        return $this;
    }

    public function getEnclosureUrl()
    {
        return $this->enclosureUrl;
    }

    public function setEnclosureUrl($enclosureUrl): self
    {
        $this->enclosureUrl = $enclosureUrl;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage($image): void
    {
        $this->image = $image;
    }

    /**
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     * @return Episode
     */
    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }
}
