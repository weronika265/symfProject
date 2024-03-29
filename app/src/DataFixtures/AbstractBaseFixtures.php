<?php
/**
 * Base fixtures.
 */

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
use InvalidArgumentException;
use LogicException;

/**
 * Class AbstractBaseFixtures.
 */
abstract class AbstractBaseFixtures extends Fixture
{
    /**
     * Faker.
     *
     * @var \Faker\Generator Faker
     */
    protected Generator $faker;

    /**
     * Persistence object manager.
     *
     * @var \Doctrine\Persistence\ObjectManager Object manager
     */
    protected ObjectManager $manager;

    /**
     * Object reference index.
     *
     * @var array Array of reference indexes
     */
    private $referenceIndex = [];

    /**
     * Load.
     *
     * @param \Doctrine\Persistence\ObjectManager $manager Persistence object manager
     */
    public function load(ObjectManager $manager): void
    {
        $this->manager = $manager;
        $this->faker = Factory::create();
        $this->loadData($manager);
    }

    /**
     * Load data.
     *
     * @param \Doctrine\Persistence\ObjectManager $manager Persistence object manager
     */
    abstract protected function loadData(ObjectManager $manager): void;

    /**
     * Create many objects at once:.
     *
     *      $this->createMany(10, function(int $i) {
     *          $user = new User();
     *          $user->setFirstName('Ryan');
     *
     *           return $user;
     *      });
     *
     * @param int      $count     Number of object to create
     * @param string   $groupName Tag these created objects with this group name,
     *                            and use this later with getRandomReference(s)
     *                            to fetch only from this specific group
     * @param callable $factory   Defines method of creating objects
     */
    protected function createMany(int $count, string $groupName, callable $factory): void
    {
        for ($i = 0; $i < $count; ++$i) {
            $entity = $factory($i);

            if (null === $entity) {
                throw new LogicException('Did you forget to return the entity object from your callback to BaseFixture::createMany()?');
            }

            $this->manager->persist($entity);

            $this->addReference(sprintf('%s_%d', $groupName, $i), $entity);
        }
    }

    /**
     * Set random reference to the object.
     *
     * @param string $groupName Object group name
     *
     * @return object Random object reference
     */
    protected function getRandomReference(string $groupName): object
    {
        if (!isset($this->referenceIndex[$groupName])) {
            $this->referenceIndex[$groupName] = [];

            foreach ($this->referenceRepository->getReferences() as $key => $reference) {
                if (0 === strpos($key, $groupName.'_')) {
                    $this->referenceIndex[$groupName][] = $key;
                }
            }
        }

        if (empty($this->referenceIndex[$groupName])) {
            throw new InvalidArgumentException(sprintf('Did not find any references saved with the group name "%s"', $groupName));
        }

        $randomReferenceKey = $this->faker->randomElement($this->referenceIndex[$groupName]);

        return $this->getReference($randomReferenceKey);
    }

    /**
     * Get array of objects references based on count.
     *
     * @param string $groupName Object group name
     * @param int    $count     Number of references
     *
     * @return array Result
     */
    protected function getRandomReferences(string $groupName, int $count): array
    {
        $references = [];
        while (count($references) < $count) {
            $references[] = $this->getRandomReference($groupName);
        }

        return $references;
    }
}
