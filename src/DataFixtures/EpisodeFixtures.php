<?php

namespace App\DataFixtures;

use App\Entity\Episode;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 50; $i++) {
            $faker = Factory::create();

            $episode = new Episode();
            $episode->setTitle($faker->title);
            $episode->setDescription($faker->text(150));
            $episode->setEnclosureUrl($faker->url);
            $episode->setPublishedAt($faker->dateTime);

            $podcast = $this->getReference(PodcastFixtures::PODCAST_REFERENCE);
            $episode->setPodcast($podcast);
            $manager->persist($episode);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            PodcastFixtures::class,
        );
    }
}
