<?php

namespace Product\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Product\Entity\User;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $user = new User('test_user');
        $user->setPassword('password');
        $manager->persist($user);
        $manager->flush();

        // Сохраняем для дальнейшего использования в тестах
        $this->addReference('test-user', $user);
    }
}
