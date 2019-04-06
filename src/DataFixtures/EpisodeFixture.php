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
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        $faker->addProvider(new FileLinkProvider($faker));

        for ($i = 0; $i < 20; $i++) {
            $episode = (new Episode())
                ->setTitle($faker->text)
                ->setDescription($faker->sentences(3, true))
                ->setPublishedAt($faker->dateTime)
                ->setEnclosureUrl($faker->audioLink)
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
