<?php
/**
 * Contact fixtures.
 */

namespace App\DataFixtures;

use App\Entity\Contact;
use Doctrine\Persistence\ObjectManager;

/**
 * Class ContactFixtures.
 */
class ContactFixtures extends AbstractBaseFixtures
{
    /**
     * Load data.
     *
     * @param \Doctrine\Persistence\ObjectManager $manager Persistence object manager
     */
    public function loadData(ObjectManager $manager): void
    {
        for ($i = 0; $i < 10; ++$i) {
            $contact = new Contact();
            $contact->setFirstName($this->faker->firstName);
            $contact->setSurname($this->faker->lastName);
            $contact->setPhoneNumber($this->faker->e164PhoneNumber);
            $contact->setEmail($this->faker->email);
            $this->manager->persist($contact);
        }

        $manager->flush();
    }
}
