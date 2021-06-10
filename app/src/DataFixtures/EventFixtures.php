<?php
/**
 * Event fixture.
 */

namespace App\DataFixtures;

use App\Entity\Event;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Persistence\ObjectManager;

/**
 * Class EventFixtures.
 */
class EventFixtures extends AbstractBaseFixtures implements DependentFixtureInterface
{
    /**
     * Load data.
     *
     * @param \Doctrine\Persistence\ObjectManager $manager Persistence object manager
     */
    public function loadData(ObjectManager $manager): void
    {
        $this->createMany(40, 'events', function ($i) {
            $event = new Event();
            $event->setName($this->faker->word);
            $event->setDate($this->faker->dateTimeThisYear($max = 'now', $timezone = null));
            $event->setDescription($this->faker->sentence);
            $event->setCategory($this->getRandomReference('categories'));
            $event->addTag($this->getRandomReference('tags'));

            /*            $tags = $this->getRandomReference(
                            'tags',
                            $this->faker->numberBetween(0, 5)
                        );

                        foreach ($tags as $tag) {
                            $event->addTag($tag);
                        }*/

            return $event;
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
        return [CategoryFixtures::class, TagFixtures::class];
    }
}
