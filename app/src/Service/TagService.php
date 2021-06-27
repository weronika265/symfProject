<?php
/**
 * Tag service.
 */

namespace App\Service;

use App\Entity\Tag;
use App\Repository\TagRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * Class TagService.
 */
class TagService
{
    /**
     * Tag repository.
     *
     * @var TagRepository Tag repository
     */
    private TagRepository $tagRepository;

    /**
     * Paginator.
     *
     * @var \Knp\Component\Pager\PaginatorInterface Paginator
     */
    private PaginatorInterface $paginator;

    /**
     * TagService constructor.
     *
     * @param \App\Repository\TagRepository           $tagRepository Tag repository
     * @param \Knp\Component\Pager\PaginatorInterface $paginator     Paginator
     */
    public function __construct(TagRepository $tagRepository, PaginatorInterface $paginator)
    {
        $this->tagRepository = $tagRepository;
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
            $this->tagRepository->queryAll(),
            $page,
            TagRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }

    /**
     * Find tag by Id.
     *
     * @param int $id Tag Id
     *
     * @return \App\Entity\Tag|null Tag entity
     */
    public function findOneById(int $id): ?Tag
    {
        return $this->tagRepository->findOneById($id);
    }

    /**
     * Find by title.
     *
     * @param string $title Tag title
     *
     * @return \App\Entity\Tag|null Tag entity
     */
    public function findOneByName(string $title): ?Tag
    {
        return $this->tagRepository->findOneByName($title);
    }

    /**
     * Save category.
     *
     * @param \App\Entity\Tag $tag Tag entity
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(Tag $tag): void
    {
        $this->tagRepository->save($tag);
    }

    /**
     * Delete category.
     *
     * @param \App\Entity\Tag $tag Tag entity
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete(Tag $tag): void
    {
        $this->tagRepository->delete($tag);
    }
}
