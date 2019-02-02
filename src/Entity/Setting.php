<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SettingRepository")
 */
class Setting
{

    const USER_INSERTED = 'user_inserted';
    const PODCAST_INSERTED = 'podcast_inserted';
    const SETTINGS_CREATED = 'settings_created';
    const IS_ONLINE = 'is_online';

    const DEFAULTS = [
        self::USER_INSERTED => [
            'default_value' => 'false'
        ],

        self::SETTINGS_CREATED => [
            'default_value' => 'false'
        ],

        self::IS_ONLINE => [
            'default_value' => 'false'
        ],

        self::PODCAST_INSERTED => [
            'default_value' => 'false'
        ]
    ];

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $value;

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
}
