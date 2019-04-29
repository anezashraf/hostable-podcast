<?php

namespace App\Command\Episode;

use App\Command\AbstractShowCommand;
use App\Entity\Episode;
use App\Entity\Podcast;

class EpisodeShowCommand extends AbstractShowCommand
{
    protected static $defaultName = 'episode:show';

    public function getEntity()
    {
        return new Episode();
    }

    public function canAcceptArgument()
    {
        return true;
    }

    public function getTableHeaders()
    {
        return [
            'id',
            'title',
            'description',
            'slug',
            'enclosure',
            'image'
        ];
    }

    public function getTableRows($entities)
    {
        return [
            $entities->getId(),
            $entities->getTitle(),
            $entities->getDescription(),
            $entities->getSlug(),
            $entities->getEnclosure(),
            $entities->getImage(),
        ];
    }
}
