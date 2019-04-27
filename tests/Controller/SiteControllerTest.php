<?php

namespace App\Tests;

use App\DataFixtures\EpisodeFixture;
use App\DataFixtures\PodcastFixture;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SiteControllerTest extends WebTestCase
{
    private $homepageClient;
    private $allPageClient;
    private $episodePageClient;
    private $homepageCrawler;
    private $allPageCrawler;
    private $episodeCrawler;
    private $rssFeedCrawler;
    private $rssFeedClient;

    public function setUp()
    {
        $this->homepageClient = static::createClient();
        $this->allPageClient = static::createClient();
        $this->episodePageClient = static::createClient();
        $this->rssFeedClient = static::createClient();

        $this->homepageCrawler = $this->homepageClient->request('GET', '/');
        $this->allPageCrawler = $this->allPageClient->request('GET', '/all');
        $this->episodeCrawler = $this->episodePageClient->request('GET', '/');
        $this->rssFeedCrawler = $this->rssFeedClient->request('GET', '/subscribe.rss');
    }


    public function testSuccessfulRequest()
    {
        $this->assertSame(200, $this->homepageClient->getResponse()->getStatusCode());
        $this->assertSame(200, $this->allPageClient->getResponse()->getStatusCode());
        $this->assertSame(200, $this->episodePageClient->getResponse()->getStatusCode());
        $this->assertSame(200, $this->rssFeedClient->getResponse()->getStatusCode());
    }

    public function testTitleAndDescriptionAppear()
    {
        $title = $this->homepageCrawler->filter('.header__information-title')->text();
        $description = $this->homepageCrawler->filter('.header__information-description')->text();

        $this->assertEquals(PodcastFixture::TITLE, $title);
        $this->assertEquals(PodcastFixture::DESCRIPTION, $description);
    }

    public function test10EpisodesShouldAppear()
    {
        $episodeList = $this->homepageCrawler->filter('.single-episode__audio-link');

        $this->assertEquals(10, count($episodeList));
    }

    public function testAllEpisodesShouldAppear()
    {
        $episodeList = $this->allPageCrawler->filter('.single-episode__audio-link');

        $this->assertEquals(EpisodeFixture::NUMBER_OF_EPISODES, count($episodeList));
    }


    public function testShouldBeDecendingOrder()
    {
        $ids = $this->homepageCrawler->filter('.single-episode__information-link')->each(function ($anchor) {
            return ltrim(substr($anchor->text(), 0, strpos($anchor->text(), " ")), '#');
        });

        $isCorrectOrder = true;

        for ($i = 0; $i < count($ids); $i++) {
            if (isset($ids[$i + 1]) && $ids[$i] < $ids[$i + 1]) {
                $isCorrectOrder = false;
            }
        }

        $this->assertTrue($isCorrectOrder, "The episodes are not in order on the page");
    }
}
