<?php

namespace App\Feed;


use App\Entity\Podcast;
use FeedIo\Factory;
use FeedIo\Feed as FeedLib;
use FeedIo\FeedIo;
use FeedIo\Feed\Item\Media;

class Feed
{
    private $feed;

    public function feed(Podcast $podcast)
    {
        $feed = new FeedLib();
        $feed->setTitle($podcast->getTitle())
            ->setDescription($podcast->getDescription());

        $episodes = $podcast->getEpisodes()->getValues();

        foreach ($episodes as $episode) {
            $enclosure = new Media();
            $enclosure->setUrl($episode->getEnclosureUrl())
                ->setType('audio/mpeg');

            $item = $feed->newItem();
            $item->setDescription($episode->getDescription());
            $item->setLastModified($episode->getPublishedAt());
            $item->setTitle($episode->getTitle());

            $item->addMedia($enclosure);

            $feed->add($item);
        }

        $feedIo = Factory::create()->getFeedIo();

        return $feedIo->format($feed, 'rss');
    }

}