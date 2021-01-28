<?php

namespace App\Dto;

use DateTimeImmutable;
use Reva2\JsonApi\Annotations\Property;
use Reva2\JsonApi\Http\Query\ListQueryParameters;

/**
 * DTO that represent query params for request API
 *
 * @author @author Konstantin Laktionov <Starternh@gmail.com>
 * @package App\Dto
 */
class PostsListParams extends ListQueryParameters
{
    /**
     * Filter entries by updatedAt
     *
     * @var DateTimeImmutable|null
     * @Property(type="DateTime<Y-m-d\TH:i:sP>", path="[from]")
     */
    protected $from;

    /**
     * @return DateTimeImmutable|null
     */
    public function getFrom(): ?DateTimeImmutable
    {
        return $this->from;
    }

    /**
     * @param DateTimeImmutable $from
     *
     * @return PostsListParams
     */
    public function setFrom(DateTimeImmutable $from): PostsListParams
    {
        $this->from = $from;

        return $this;
    }

    /**
     * @inheritdoc
     */
    protected function getAllowedIncludePaths()
    {
        return ['createdBy', 'content'];
    }

    /**
     * @inheritdoc
     */
    protected function getAllowedFields($resource)
    {
        switch ($resource) {
            case 'posts':
                return [
                    'id',
                    'rating',
                    'title',
                    'createdAt',
                    'updatedAt',
                ];
            default:
                return parent::getFieldSets();
        }
    }

    /**
     * @inheritdoc
     */
    protected function getSortableFields()
    {
        return [
            'id',
            'rating',
            'title',
            'createdAt',
            'updatedAt',
        ];
    }


    /**
     * Returns default page size
     *
     * @return int|null
     */
    protected function getDefaultPageSize()
    {
        return 10;
    }

    /**
     * Returns max page size
     *
     * @return int|null
     */
    protected function getMaxPageSize()
    {
        return 100;
    }
}
