<?php

namespace App\DataFixtures;

use App\Entity\Podcast;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class PodcastFixtures extends Fixture
{
    public const PODCAST_REFERENCE = 'podcast';

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        $podcast = new Podcast();

        $podcast->setTitle($faker->title)
            ->setDescription($faker->text(250))
            ->setAuthor($faker->name)
            ->setImage($faker->image(__DIR__ . '/../../public/img'));

        $manager->persist($podcast);
        $manager->flush();

        $this->addReference(self::PODCAST_REFERENCE, $podcast);

    }
}
