<?php

namespace App\Entity;

use App\Entity\Common\IdTrait;
use App\Entity\Common\TimestampTrait;
use App\Entity\Contracts\EntityInterface;
use App\Entity\Contracts\Updatable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SettingRepository")
 *
 * @ORM\HasLifecycleCallbacks()
 */
class Setting implements EntityInterface, Updatable
{
    use IdTrait;
    use TimestampTrait;

    /**
     *
     * @Groups("dashboard")
     * @ORM\Column(type="string", length=50)
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups("dashboard")
     */
    private $value;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups("dashboard")
     */
    private $type;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Groups("dashboard")
     */
    private $editableFromDashboard;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(?string $value): self
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getEditableFromDashboard()
    {
        return $this->editableFromDashboard;
    }

    /**
     * @param mixed $editableFromDashboard
     */
    public function setEditableFromDashboard($editableFromDashboard): self
    {
        $this->editableFromDashboard = $editableFromDashboard;

        return $this;
    }

    public function updatableProperties(): array
    {
        return ['value'];
    }
}
