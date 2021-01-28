<?php

namespace App\Repository;

use App\Dto\PostsListParams;
use App\Entity\Post;
use App\Utils\JsonApi\SortingMap;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\QueryBuilder;

/**
 * Posts repository
 *
 * @author Konstantin Laktionov <Starternh@gmail.com>
 * @package App\Repository
 *
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends BaseRepository
{
    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

    /**
     * Return posts list
     *
     * @param PostsListParams $params
     *
     * @return Post[]
     */
    public function getList(PostsListParams $params): array
    {
        $qb = $this->_em->createQueryBuilder();
        $qb
            ->select('p')
            ->from(Post::class, 'p');

        $this
            ->applyFilteringParams($qb, $params)
            ->applySortingParams(
                $qb,
                $params,
                new SortingMap(
                    'id', ['' => 'p']
                )
            )
            ->applyPaginationParams($qb, $params);

        return $qb->getQuery()->getResult();
    }

    /**
     * Apply list params to query
     *
     * @param QueryBuilder $qb
     * @param PostsListParams $params
     *
     * @return $this
     */
    private function applyFilteringParams(QueryBuilder $qb, PostsListParams $params): self
    {
        if (null !== ($from = $params->getFrom())) {
            $qb
                ->andWhere('p.createdAt > :from')
                ->setParameter('from', $from->format('Y-m-d H:i:s'));
        }

        return $this;
    }

    /**
     * Return total number of posts for metadata
     *
     * @param PostsListParams $params
     *
     * @return int
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function getCount(PostsListParams $params): int
    {
        $qb = $this->_em->createQueryBuilder();
        $qb
            ->select('count(p)')
            ->from(Post::class, 'p');

        $this
            ->applyFilteringParams($qb, $params);

        return (int)$qb->getQuery()->getSingleScalarResult();
    }
}
