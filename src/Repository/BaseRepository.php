<?php

namespace App\Repository;

use App\Utils\JsonApi\SortingMap;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Query\QueryBuilder as DbalQueryBuilder;
use Doctrine\ORM\QueryBuilder as OrmQueryBuilder;
use Reva2\JsonApi\Http\Query\ListQueryParameters;

/**
 * Base class for data repositories
 *
 * @author Konstantin Laktionov <Starternh@gmail.com>
 * @package App\Repository
 */
abstract class BaseRepository extends ServiceEntityRepository
{
    /**
     * Apply pagination parameters
     *
     * @param OrmQueryBuilder|DbalQueryBuilder $qb
     * @param ListQueryParameters $params
     *
     * @return $this
     */
    protected function applyPaginationParams($qb, ListQueryParameters $params): self
    {
        $page = $params->getPaginationParameters();

        if ($page['size'] && $page['number']) {
            $offset = $page['size'] * ($page['number'] - 1);

            $qb->setMaxResults($page['size'])->setFirstResult($offset);
        }

        return $this;
    }

    /**
     * Apply sorting parameters
     *
     * @param OrmQueryBuilder|DbalQueryBuilder $qb
     * @param ListQueryParameters $params
     * @param SortingMap $map
     *
     * @return $this
     */
    protected function applySortingParams($qb, ListQueryParameters $params, SortingMap $map): self
    {
        $criteria = [];

        $sortParams = $params->getSortParameters();
        if (null !== $sortParams) {
            foreach ($sortParams as $parameter) {
                $field = $this->getQueryFieldName($parameter->getField(), $map);

                $criteria[$field] = ($parameter->isAscending()) ? 'ASC' : 'DESC';
            }
        }

        if ((0 === count($criteria)) && (null !== ($defaultParameter = $map->getDefaultSortingField()))) {
            $field = $this->getQueryFieldName($defaultParameter->getField(), $map);

            $criteria[$field] = ($defaultParameter->isAscending()) ? 'ASC' : 'DESC';
        }

        foreach ($criteria as $field => $order) {
            $qb->addOrderBy($field, $order);
        }

        return $this;
    }

    /**
     * Returns database query field name
     *
     * @param $field
     * @param SortingMap $map
     *
     * @return string
     */
    protected function getQueryFieldName($field, SortingMap $map): string
    {
        $parts = explode('.', $field);

        if (1 === count($parts)) {
            $resourceField = $parts[0];
            $resource = '';
        } else {
            $resourceField = array_pop($parts);
            $resource = implode('.', $parts);
        }

        $resourceAlias = $map->getResourceAlias($resource);

        if (null !== ($fieldAlias = $map->getFieldAlias($resourceField, $resource))) {
            $resourceAlias = '';
            $resourceField = $fieldAlias;
        }

        return (!empty($resourceAlias)) ? $resourceAlias.'.'.$resourceField : $resourceField;
    }
}
