<?php
/**
 * Contact fixtures.
 */

namespace App\DataFixtures;

use App\Entity\Contact;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Persistence\ObjectManager;

/**
 * Class ContactFixtures.
 */
class ContactFixtures extends AbstractBaseFixtures implements DependentFixtureInterface
{
    /**
     * Load data.
     *
     * @param \Doctrine\Persistence\ObjectManager $manager Persistence object manager
     */
    public function loadData(ObjectManager $manager): void
    {
        $this->createMany(100, 'contacts', function ($i) {
            $contact = new Contact();
            $contact->setFirstName($this->faker->firstName);
            $contact->setSurname($this->faker->lastName);
            $contact->setPhoneNumber($this->faker->e164PhoneNumber);
            $contact->setEmail($this->faker->email);
            $contact->addTag($this->getRandomReference('tags'));

/*            $tags = $this->getRandomReference(
                'tags',
                    $this->faker->numberBetween(0, 5)
            );

            foreach ($tags as $tag) {
                $contact->addTag($tag);
            }*/

            $contact->setAuthor($this->getRandomReference('users'));

            return $contact;
        });

        $manager->flush();
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on.
     *
     * @psalm-return array<class-string<FixtureInterface>>
     */
    public function getDependencies(): array
    {
        return [TagFixtures::class, UserFixtures::class];
    }
}
