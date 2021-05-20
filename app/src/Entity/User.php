<?php
/**
 * User entity.
 */

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\Json;

/**
 * Class User.
 *
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository", repositoryClass=UserRepository::class)
 * @ORM\Table(name="users")
 */
class User
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
     * Username.
     *
     * @var string
     *
     * @ORM\Column(type="string", length=32)
     */
    private $username;

    /**
     * Email.
     *
     * @var string
     *
     * @ORM\Column(type="string", length=50)
     */
    private $email;

    /**
     * Password.
     *
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * Roles.
     *
     * @var json
     *
     * @ORM\Column(type="json")
     */
    private $roles = [];

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
     * Getter for Username.
     *
     * @return string|null Username
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * Setter for Username.
     *
     * @param string $username Username
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
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
     * @param string $email Email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * Getter for Password.
     *
     * @return string|null Password
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * Setter for Password.
     *
     * @param string $password Password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * Getter for Roles.
     *
     * @return array|null Roles
     */
    public function getRoles(): ?array
    {
        return $this->roles;
    }

    /**
     * Setter for Roles.
     *
     * @param array $roles Roles
     */
    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }
}
