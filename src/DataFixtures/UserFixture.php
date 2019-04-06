<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class UserFixture extends Fixture
{
    public const USER_OBJ = 'user_obj';

    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        $user = (new User())->setEnabled(1)
            ->setRoles(['ROLE_ADMIN'])
            ->setEmail('fake@fake.com')
            ->setUsername("mrs fake")
            ->setPassword("fake_password");

        $manager->persist($user);
        $manager->flush();

        $this->addReference(self::USER_OBJ, $user);
    }
}
