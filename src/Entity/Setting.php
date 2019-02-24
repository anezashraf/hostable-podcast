<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SettingRepository")
 */
class Setting implements EntityInterface
{

    const USER_INSERTED = 'user_inserted';
    const PODCAST_INSERTED = 'podcast_inserted';
    const SETTINGS_CREATED = 'settings_created';
    const IS_ONLINE = 'is_online';

    const DEFAULTS = [
        self::USER_INSERTED => [
            'default_value' => 'false',
            'type' => 'boolean',
            'editable_from_dashboard' => false
        ],

        self::SETTINGS_CREATED => [
            'default_value' => 'false',
            'type' => 'boolean',
            'editable_from_dashboard' => false,
        ],

        self::IS_ONLINE => [
            'default_value' => 'false',
            'type' => 'boolean',
            'editable_from_dashboard' => true
        ],

        self::PODCAST_INSERTED => [
            'default_value' => 'false',
            'type' => 'boolean',
            'editable_from_dashboard' => false
        ]
    ];

    /**
     * @Groups("dashboard")
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

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
}
