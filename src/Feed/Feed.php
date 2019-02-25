<?php

namespace App\Feed;

use App\Entity\Podcast;
use FeedIo\Factory;
use FeedIo\Feed as FeedLib;
use FeedIo\FeedIo;
use FeedIo\Feed\Item\Media;

class Feed
{
    public function feed(Podcast $podcast, string $host)
    {
        $feed = new FeedLib();
        $feed->setTitle($podcast->getTitle())
            ->setDescription($podcast->getDescription());

        $episodes = $podcast->getEpisodes()->getValues();

        foreach ($episodes as $episode) {
            if ($episode->getEnclosureUrl()) {
                $enclosure = new Media();
                $enclosure->setUrl($host  . $episode->getEnclosureUrl())
                    ->setType('audio/mpeg');

                $item = $feed->newItem();
                $item->setDescription($episode->getDescription());
                $item->setLastModified($episode->getPublishedAt());
                $item->setTitle($episode->getTitle());
                $item->setLink($host  . 'episode' . $episode->getId());

                $item->addMedia($enclosure);

                $feed->add($item);
            }
        }

        $feedIo = Factory::create()->getFeedIo();

        return $feedIo->format($feed, 'rss');
    }
}
