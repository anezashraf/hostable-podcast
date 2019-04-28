<?php

namespace App\DataFixtures;

use App\Entity\Episode;
use App\Entity\Podcast;
use App\Tests\Resources\FileLinkProvider;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class EpisodeFixture extends Fixture implements DependentFixtureInterface
{
    public const NUMBER_OF_EPISODES = 20;

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        $faker->addProvider(new FileLinkProvider($faker));

        $numberOfEpisodes = self::NUMBER_OF_EPISODES;

        if (getenv("mode") === 'installation') {
            $numberOfEpisodes = 0;
        }

        for ($i = 0; $i < $numberOfEpisodes; $i++) {
            $episode = (new Episode())
                ->setTitle($faker->text(30))
                ->setDescription($faker->sentences(10, true))
                ->setPublishedAt($faker->dateTime)
                ->setEnclosure($faker->audioLink)
                ->setSlug($faker->slug)
                ->setImage($faker->imageLink);

            $episode->setPodcast($this->getReference(PodcastFixture::PODCAST_OBJ));

            $manager->persist($episode);
        }

        $manager->flush();
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on
     *
     * @return array
     */
    public function getDependencies()
    {
        return [
            PodcastFixture::class,
        ];
    }
}
