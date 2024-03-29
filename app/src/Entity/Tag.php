<?php
/**
 * Tag entity.
 */

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Tag.
 *
 * @ORM\Entity(repositoryClass="App\Repository\TagRepository")
 * @ORM\Table(name="tags")
 *
 * @UniqueEntity(fields={"name"})
 */
class Tag
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
     * Name.
     *
     * @var string
     *
     * @ORM\Column(
     *     type="string",
     *     length=32,
     * )
     *
     * @Assert\Type(type="string")
     * @Assert\NotBlank
     * @Assert\Length(
     *     min="3",
     *     max="32",
     * )
     */
    private $name;

    /**
     * Events.
     *
     * @var \Doctrine\Common\Collections\ArrayCollection|\App\Entity\Event[] Events
     *
     * @ORM\ManyToMany(
     *     targetEntity="App\Entity\Event",
     *     mappedBy="tags",
     *     fetch="EXTRA_LAZY",
     * )
     */
    private $events;

    /**
     * Contacts.
     *
     * @var \Doctrine\Common\Collections\ArrayCollection|\App\Entity\Contact[] Contacts
     *
     * @ORM\ManyToMany(
     *     targetEntity="App\Entity\Contact",
     *     mappedBy="tags",
     *     fetch="EXTRA_LAZY",
     * )
     */
    private $contacts;

    /**
     * Tag constructor.
     */
    public function __construct()
    {
        $this->events = new ArrayCollection();
        $this->contacts = new ArrayCollection();
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
     * Getter for Name.
     *
     * @return string|null Name
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Setter for Name.
     *
     * @param string $name Name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * Getter for events.
     *
     * @return \Doctrine\Common\Collections\Collection|\App\Entity\Event[] Events collection
     */
    public function getEvents(): Collection
    {
        return $this->events;
    }

    /**
     * Add event to collection.
     *
     * @param \App\Entity\Event $event Event entity
     */
    public function addEvent(Event $event): void
    {
        if (!$this->events->contains($event)) {
            $this->events[] = $event;
            $event->addTag($this);
        }
    }

    /**
     * Remove event from collection.
     *
     * @param \App\Entity\Event $event Event entity
     */
    public function removeEvent(Event $event): void
    {
        if ($this->events->contains($event)) {
            $this->events->removeElement($event);
            $event->removeTag($this);
        }
    }

    /**
     * Getter for contacts.
     *
     * @return \Doctrine\Common\Collections\Collection|\App\Entity\Contact[] Contacts collection
     */
    public function getContacts(): Collection
    {
        return $this->contacts;
    }

    /**
     * Add contact to collection.
     *
     * @param \App\Entity\Contact $contact Contact entity
     */
    public function addContact(Contact $contact): void
    {
        if (!$this->contacts->contains($contact)) {
            $this->contacts[] = $contact;
            $contact->addTag($this);
        }
    }

    /**
     * Remove contact from collection.
     *
     * @param \App\Entity\Contact $contact Contact entity
     */
    public function removeContact(Contact $contact): void
    {
        if ($this->contacts->removeElement($contact)) {
            $contact->removeTag($this);
        }
    }
}
