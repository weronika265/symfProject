<?php
/**
 * UserData fixtures.
 */

namespace App\DataFixtures;

use App\Entity\UserData;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Persistence\ObjectManager;

/**
 * Class UserDataFixtures.
 */
class UserDataFixtures extends AbstractBaseFixtures implements DependentFixtureInterface
{
    /**
     * Load data.
     *
     * @param ObjectManager $manager Object manager
     */
    public function loadData(ObjectManager $manager): void
    {
        $this->createMany(4, 'userdata', function ($i) {
            $userData = new userData();
            $userData->setData($this->faker->sentence);
            $userData->setFirstName($this->faker->firstName);
            $userData->setSurname($this->faker->lastName);
            /*$userData->setUser($this->getRandomReference('users'));*/

            return $userData;
        });

        $manager->flush();
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on.
     *
     * @psalm-return array<class-string<FixtureInterface>>
     */
    public function getDependencies()
    {
        return [UserFixtures::class];
    }
}
