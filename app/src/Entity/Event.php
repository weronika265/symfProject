<?php
/**
 * Event entity.
 */

namespace App\Entity;

use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Event.
 *
 * @ORM\Entity(repositoryClass="App\Repository\EventRepository")
 * @ORM\Table(name="events")
 *
 */
class Event
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
     *     length=45,
     * )
     *
     * @Assert\Type(type="string")
     * @Assert\NotBlank
     * @Assert\Length(
     *     max="64",
     * )
     */
    private $name;

    /**
     * Date.
     *
     * @var DateTimeInterface
     *
     * @ORM\Column(type="datetime")
     *
     * @Assert\Type(type="datetime")
     * @Assert\NotBlank
     */
    private $date;

    /**
     * Description.
     *
     * @var string
     *
     * @ORM\Column(
     *     type="string",
     *     length=255,
     *     nullable=true,
     * )
     *
     * @Assert\Type(type="string")
     * @Assert\Length(
     *     min="5",
     *     max="255",
     * )
     */
    private $description;

    /**
     * Category.
     *
     * @var \App\Entity\Category Category
     *
     * @ORM\ManyToOne(
     *     targetEntity="App\Entity\Category",
     *     inversedBy="events"
     * )
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * Tags.
     *
     * @var array
     *
     * @ORM\ManyToMany(
     *     targetEntity="App\Entity\Tag",
     *     inversedBy="events",
     * )
     * @ORM\JoinTable(name="events_tags")
     */
    private $tags;

    /**
     * Event constructor.
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
     * Getter for Date.
     *
     * @return DateTimeInterface|null Date
     */
    public function getDate(): ?DateTimeInterface
    {
        return $this->date;
    }

    /**
     * Setter for Date.
     *
     * @param DateTimeInterface $date Date
     */
    public function setDate(DateTimeInterface $date): void
    {
        $this->date = $date;
    }

    /**
     * Getter for Description.
     *
     * @return string|null Description
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Setter for Description.
     *
     * @param string|null $description Description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    /**
     * Getter for Category.
     *
     * @return Category|null Category
     */
    public function getCategory(): ?Category
    {
        return $this->category;
    }

    /**
     * Setter for Category.
     *
     * @param Category|null $category Category
     */
    public function setCategory(?Category $category): void
    {
        $this->category = $category;
    }

    /**
     * Getter for tags.
     *
     * @return \Doctrine\Common\Collections\Collection|\App\Entity\Tag[] Tags collection
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    /**
     * Add tag to collection.
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
     * Remove tag from collection.
     *
     * @param \App\Entity\Tag $tag Tag entity
     */
    public function removeTag(Tag $tag): void
    {
        if ($this->tags->contains($tag)) {
            $this->tags->removeElement($tag);
        }
    }
}
