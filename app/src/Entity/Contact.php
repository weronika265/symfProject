<?php
/**
 * Contact entity.
 */

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Contact.
 *
 * @ORM\Entity(repositoryClass="App\Repository\ContactRepository")
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
     * @ORM\Column(
     *     type="string",
     *     length=45,
     * )
     *
     * @Assert\Type(type="string")
     * @Assert\NotBlank
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
     *     max="64",
     * )
     */
    private $surname;

    /**
     * Phone number.
     *
     * @var string
     *
     * @ORM\Column(
     *     type="string",
     *     length=15,
     *     nullable=true,
     * )
     *
     * @Assert\Type(type="string")
     * @Assert\Length(
     *     min="10",
     *     max="15",
     * )
     */
    private $phoneNumber;

    /**
     * Email.
     *
     * @var string
     *
     * @ORM\Column(
     *     type="string",
     *     length=50,
     *     nullable=true,
     * )
     *
     * @Assert\Type(type="string")
     * @Assert\Length(
     *     min="8",
     *     max="50",
     * )
     */
    private $email;

    /**
     * Tags.
     *
     * @ORM\ManyToMany(
     *     targetEntity="App\Entity\Tag",
     *     inversedBy="contacts",
     *     fetch="EXTRA_LAZY",
     * )
     *  @ORM\JoinTable(name="contacts_tags")
     */
    private $tags;

    /**
     * Author.
     *
     * @var \App\Entity\User
     *
     * @ORM\ManyToOne(
     *     targetEntity="App\Entity\User",
     *     fetch="EXTRA_LAZY",
     * )
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

    /**
     * Contact constructor.
     */
    public function __construct()
    {
        $this->tags = new ArrayCollection();
    }

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

    /**
     * Getter for Tags.
     *
     * @return \Doctrine\Common\Collections\Collection|\App\Entity\Tag[] Tags collection
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    /**
     * Add Tag to collection.
     *
     * @param \App\Entity\Tag $tag Tag entity
     */
    public function addTag(Tag $tag): void
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
        }
    }

    /**
     * Remove Tag from collection.
     *
     * @param \App\Entity\Tag $tag Tag entity
     */
    public function removeTag(Tag $tag): void
    {
        if ($this->tags->contains($tag)) {
            $this->tags->removeElement($tag);
        }
    }

    /**
     * Getter for Author.
     *
     * @return \App\Entity\User|null Author
     */
    public function getAuthor(): ?User
    {
        return $this->author;
    }

    /**
     * Setter for Author.
     *
     * @param \App\Entity\User|null $author Author
     */
    public function setAuthor(?User $author): void
    {
        $this->author = $author;
    }
}
