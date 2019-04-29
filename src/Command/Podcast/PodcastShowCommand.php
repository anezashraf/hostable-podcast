<?php

namespace App\Command\Podcast;

use App\Command\AbstractShowCommand;
use App\Entity\Podcast;

class PodcastShowCommand extends AbstractShowCommand
{
    protected static $defaultName = 'podcast:show';

    public function getEntity()
    {
        return new Podcast;
    }

    public function canAcceptArgument()
    {
        return false;
    }

    public function getTableHeaders()
    {
        return [
            'id',
            'title',
            'description',
            'image',
        ];
    }

    public function getTableRows($entities)
    {
        return [
            $entities->getId(),
            $entities->getTitle(),
            $entities->getImage(),
        ];
    }
}
