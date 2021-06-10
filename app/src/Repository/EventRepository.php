<?php
/**
 * Event repository.
 */

namespace App\Repository;

use App\Entity\Event;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

/**
 * @method Event|null find($id, $lockMode = null, $lockVersion = null)
 * @method Event|null findOneBy(array $criteria, array $orderBy = null)
 * @method Event[]    findAll()
 * @method Event[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventRepository extends ServiceEntityRepository
{

    /**
     * Items per page.
     *
     * Use constants to define configuration options that rarely change instead
     * of specifying them in app/config/config.yml.
     * See https://symfony.com/doc/current/best_practices.html#configuration
     *
     * @constant int
     */
    const PAGINATOR_ITEMS_PER_PAGE = 6;
    const PAGINATOR_ITEMS_PER_CALENDAR_PAGE = 15;

    /**
     * EventRepository constructor.
     *
     * @param \Doctrine\Persistence\ManagerRegistry $registry Manager registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Event::class);
    }

    /**
     * Save record.
     *
     * @param \App\Entity\Event $event Event entity
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(Event $event): void
    {
        $this->_em->persist($event);
        $this->_em->flush();
    }

    /**
     * Delete record.
     *
     * @param \App\Entity\Event $event Event entity
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete(Event $event): void
    {
        $this->_em->remove($event);
        $this->_em->flush();
    }

    /**
     * Query all records.
     *
     * @return \Doctrine\ORM\QueryBuilder Query builder
     */
    public function queryAll(): QueryBuilder
    {
        return $this->getOrCreateQueryBuilder()
            ->select(
                'partial event.{id, name, date, description}',
                'partial category.{id, name}',
                'partial tags.{id, name}'
            )
/*            ->where('event.date = 2021-05-12 02:37:57')*/
            ->join('event.category', 'category')
            ->leftJoin('event.tags', 'tags')
            ->orderBy('event.date', 'DESC');
    }

    /**
     * Get or create new query builder.
     *
     * @param \Doctrine\ORM\QueryBuilder|null $queryBuilder Query builder
     *
     * @return \Doctrine\ORM\QueryBuilder Query builder
     */
    private function getOrCreateQueryBuilder(QueryBuilder $queryBuilder = null): QueryBuilder
    {
        return $queryBuilder ?? $this->createQueryBuilder('event');
    }

    // /**
    //  * @return Event[] Returns an array of Event objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Event
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
