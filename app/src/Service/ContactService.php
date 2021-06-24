<?php
/**
 *  Contact service.
 */

namespace App\Service;

use App\Entity\Contact;
use App\Repository\ContactRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class ContactService.
 */
class ContactService
{
    /**
     * Contact repository.
     *
     * @var \App\Repository\ContactRepository Contact repository
     */
    private ContactRepository $contactRepository;

    /**
     * Paginator.
     *
     * @var \Knp\Component\Pager\PaginatorInterface Paginator
     */
    private PaginatorInterface $paginator;

    /**
     * Tag service.
     *
     * @var \App\Service\TagService Tag service
     */
    private $tagService;

    /**
     * ContactService constructor.
     *
     * @param \App\Repository\ContactRepository       $contactRepository Contact repository
     * @param \Knp\Component\Pager\PaginatorInterface $paginator         Paginator
     * @param \App\Service\TagService                 $tagService        Tag service
     */
    public function __construct(ContactRepository $contactRepository, PaginatorInterface $paginator, TagService $tagService)
    {
        $this->contactRepository = $contactRepository;
        $this->paginator = $paginator;
        $this->tagService = $tagService;
    }

    /**
     * Create paginated list.
     *
     * @param int                                                 $page    Page number
     * @param \Symfony\Component\Security\Core\User\UserInterface $user    User entity
     * @param array                                               $filters Filters array
     *
     * @return \Knp\Component\Pager\Pagination\PaginationInterface Paginated list
     */
    public function createPaginatedList(int $page, UserInterface $user, array $filters = []): PaginationInterface
    {
        $filters = $this->prepareFilters($filters);

        return $this->paginator->paginate(
            $this->contactRepository->queryByAuthor($user, $filters),
            $page,
            ContactRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }

    /**
     * Save contact.
     *
     * @param \App\Entity\Contact $contact Contact entity
     * @param \App\Entity\User    $user    User interface
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(Contact $contact, UserInterface $user): void
    {
        $contact->setAuthor($user);
        $this->contactRepository->save($contact);
    }

    /**
     * Delete contact.
     *
     * @param \App\Entity\Contact $contact Contact entity
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete(Contact $contact): void
    {
        $this->contactRepository->delete($contact);
    }

    /**
     * Prepare filters for the tasks list.
     *
     * @param array $filters Raw filters from request
     *
     * @return array Result array of filters
     */
    private function prepareFilters(array $filters): array
    {
        $resultFilters = [];

        if (isset($filters['tag_id']) && is_numeric($filters['tag_id'])) {
            $tag = $this->tagService->findOneById($filters['tag_id']);
            if (null !== $tag) {
                $resultFilters['tag'] = $tag;
            }
        }

        return $resultFilters;
    }
}
