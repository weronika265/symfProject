<?php
/**
 *  Event service.
 */

namespace App\Service;

use App\Entity\Event;
use App\Repository\EventRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class EventService.
 */
class EventService
{
    /**
     * Event repository.
     *
     * @var \App\Repository\EventRepository Event repository
     */
    private EventRepository $eventRepository;

    /**
     * Paginator.
     *
     * @var \Knp\Component\Pager\PaginatorInterface Paginator
     */
    private PaginatorInterface $paginator;

    /**
     * EventService constructor.
     *
     * @param \App\Repository\EventRepository         $eventRepository Event repository
     * @param \Knp\Component\Pager\PaginatorInterface $paginator       Paginator
     */
    public function __construct(EventRepository $eventRepository, PaginatorInterface $paginator)
    {
        $this->eventRepository = $eventRepository;
        $this->paginator = $paginator;
    }

    /**
     * Create paginated list.
     *
     * @param int $page Page number
     *
     * @return \Knp\Component\Pager\Pagination\PaginationInterface Paginated list
     */
    public function createPaginatedList(int $page): PaginationInterface
    {
        return $this->paginator->paginate(
            $this->eventRepository->queryAll(),
            $page,
            EventRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }

    /**
     * Save event.
     *
     * @param \App\Entity\Event $event Event entity
     * @param \App\Entity\User  $user  User interface
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(Event $event, UserInterface $user): void
    {
        $event->setAuthor($user);
        $this->eventRepository->save($event);
    }

    /**
     * Delete event.
     *
     * @param \App\Entity\Event $event Event entity
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete(Event $event): void
    {
        $this->eventRepository->delete($event);
    }
}
