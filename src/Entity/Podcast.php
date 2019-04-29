<?php

namespace App\Entity;

use App\Entity\Common\IdTrait;
use App\Entity\Common\TimestampTrait;
use App\Entity\Contracts\EntityInterface;
use App\Entity\Contracts\Updatable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PodcastRepository")
 *
 * @ORM\HasLifecycleCallbacks()
 */
class Podcast implements EntityInterface, Updatable
{
    use IdTrait;
    use TimestampTrait;

    /**
     * @Assert\NotBlank

     * @Assert\Length(min=3, max=10)
     *
     * @ORM\Column(type="string", length=255)
     *
     * @Groups("dashboard")
     */
    private $title;

    /**
     * @Assert\NotBlank
     *
     * @Assert\Length(min=3, max=255)
     *
     * @ORM\Column(type="text", nullable=true)
     *
     * @Groups("dashboard")

     */
    private $description;

    /**
     * @Groups("dashboard")
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Episode", mappedBy="podcast", orphanRemoval=true)
     */
    private $episodes;

    public function __construct()
    {
        $this->episodes = new ArrayCollection();
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

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image): self
    {
        $this->image = $image;

        return $this;
    }


    /**
     * @return Collection|Episode[]
     */
    public function getEpisodes(): Collection
    {
        return $this->episodes;
    }

    public function addEpisode(Episode $episode): self
    {
        if (!$this->episodes->contains($episode)) {
            $this->episodes[] = $episode;
            $episode->setPodcast($this);
        }

        return $this;
    }

    public function removeEpisode(Episode $episode): self
    {
        if ($this->episodes->contains($episode)) {
            $this->episodes->removeElement($episode);
            // set the owning side to null (unless already changed)
            if ($episode->getPodcast() === $this) {
                $episode->setPodcast(null);
            }
        }

        return $this;
    }

    public function updatableProperties() : array
    {
        return [
            'title',
            'description',
            'image',
        ];
    }

    public function __toString() : string
    {
        return $this->title;
    }
}
