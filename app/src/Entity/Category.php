<?php
/**
 * Category entity.
 */

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Category.
 *
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 * @ORM\Table(name="categories")
 *
 * @UniqueEntity(fields={"name"})
 */
class Category
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
     * @ORM\OneToMany(
     *     targetEntity="App\Entity\Event",
     *     mappedBy="category"
     * )
     */
    private Collection $events;

    /**
     * Category constructor.
     */
    public function __construct()
    {
        $this->events = new ArrayCollection();
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
     * Getter for Event.
     *
     * @return Collection|Event[] Event
     */
    public function getEvents(): Collection
    {
        return $this->events;
    }

    /**
     * Add Event.
     *
     * @param Event $event Event
     */
    public function addEvent(Event $event): void
    {
        if (!$this->events->contains($this)) {
            $this->events[] = $event;
            $event->setCategory($this);
        }
    }

    /**
     * Remove Event.
     *
     * @param Event $event Event
     */
    public function removeEvent(Event $event): void
    {
        if ($this->events->contains($event)) {
            $this->events->removeElement($event);
            if ($event->getCategory() === $this) {
                $event->setCategory(null);
            }
        }
    }
}
