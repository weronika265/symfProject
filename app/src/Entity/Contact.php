<?php
/**
 * Contact entity.
 */

namespace App\Entity;

use App\Repository\ContactRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Contact.
 *
 * @ORM\Entity(repositoryClass=ContactRepository::class)
 * @ORM\Table(name="contacts")
 */
class Contact
{
    /**
     * Primary key.
     *
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * First name.
     *
     * @var string
     *
     * @ORM\Column(type="string", length=45)
     */
    private $firstName;

    /**
     * Surname.
     *
     * @var string
     *
     * @ORM\Column(type="string", length=45, nullable=true)
     */
    private $surname;

    /**
     * Phone number.
     *
     * @var string
     *
     * @ORM\Column(type="string", length=15, nullable=true)
     */
    private $phoneNumber;

    /**
     * Email.
     *
     * @var string
     *
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $email;

    /**
     * Getter for Id.
     *
     * @return int|null Result
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Getter for First name.
     *
     * @return string|null First name
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * Setter for First name.
     *
     * @param string $firstName First name
     */
    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * Getter for Surname.
     *
     * @return string|null Surname
     */
    public function getSurname(): ?string
    {
        return $this->surname;
    }

    /**
     * Setter for Surname.
     *
     * @param string|null $surname Surname
     */
    public function setSurname(?string $surname): void
    {
        $this->surname = $surname;
    }

    /**
     * Getter for Phone number.
     *
     * @return string|null Phone number
     */
    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    /**
     * Setter for Phone number.
     *
     * @param string|null $phoneNumber Phone number
     */
    public function setPhoneNumber(?string $phoneNumber): void
    {
        $this->phoneNumber = $phoneNumber;
    }

    /**
     * Getter for Email.
     *
     * @return string|null Email
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * Setter for Email.
     *
     * @param string|null $email Email
     */
    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }
}
