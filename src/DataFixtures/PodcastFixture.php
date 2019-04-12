<?php

namespace App\DataFixtures;

use App\Entity\Podcast;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class PodcastFixture extends Fixture implements DependentFixtureInterface
{
    public const TITLE = 'Acme Podcast';
    public const DESCRIPTION = 'We discuss everything from politics to football and even cars!';
    const PODCAST_OBJ = 'podcast_obj';

    public function load(ObjectManager $manager)
    {
         $podcast = (new Podcast)
             ->setDescription(self::DESCRIPTION)
             ->setTitle(self::TITLE)
             ->setImage('/some_image_url');

         $podcast->setUser($this->getReference(UserFixture::USER_OBJ));
        $manager->persist($podcast);

        $this->addReference(self::PODCAST_OBJ, $podcast);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixture::class,
        ];
    }
}
