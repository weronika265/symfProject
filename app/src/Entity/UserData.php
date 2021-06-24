<?php
/**
 * Userdata entity.
 */

namespace App\Entity;

use App\Repository\UserDataRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class UserData.
 *
 * @ORM\Entity(repositoryClass="App\Repository\UserDataRepository")
 * @ORM\Table(name="user_data")
 *
 * @UniqueEntity(fields={"data"})
 */
class UserData
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
     * Data.
     *
     * @var string
     *
     * @ORM\Column(
     *     type="string",
     *     length=255,
     * )
     *
     * @Assert\Type(type="string")
     * @Assert\NotBlank
     * @Assert\Length(
     *     min="10",
     *     max="255",
     * )
     */
    private $data;

    /**
     * First name.
     *
     * @var string
     *
     * @ORM\Column(
     *     type="string",
     *     length=45,
     *     nullable=true,
     * )
     *
     * @Assert\Type(type="string")
     * @Assert\Length(
     *     min="3",
     *     max="45",
     * )
     */
    private $firstName;

    /**
     * Surname.
     *
     * @var string
     *
     * @ORM\Column(
     *     type="string",
     *     length=45,
     *     nullable=true,
     * )
     *
     * @Assert\Type(type="string")
     * @Assert\Length(
     *     min="3",
     *     max="45",
     * )
     */
    private $surname;

    /**
     * User.
     *
     * @var User
     *
     * @ORM\OneToOne(
     *     targetEntity="\App\Entity\User",
     *     inversedBy="userData",
     *     fetch="EXTRA_LAZY",
     * )
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

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
     * Getter for Data.
     *
     * @return string|null data
     */
    public function getData(): ?string
    {
        return $this->data;
    }

    /**
     * Setter for Data.
     *
     * @param string $data Data
     */
    public function setData(string $data): void
    {
        $this->data = $data;
    }

    /**
     * Setter for First name.
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
     * @param string|null $firstName First name
     */
    public function setFirstName(?string $firstName): void
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
     * Getter for User.
     *
     * @return \App\Entity\User|null User
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * Setter for User.
     *
     * @param \App\Entity\User|null $user User
     */
    public function setUser(?User $user): void
    {
        $this->user = $user;
    }
}
