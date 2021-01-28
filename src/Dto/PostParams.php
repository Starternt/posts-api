<?php

namespace App\Dto;

use Reva2\JsonApi\Http\Query\QueryParameters;

/**
 * Query parameters for endpoint that returns information about
 * specified post
 *
 * @author Konstantin Laktionov <Starternh@gmail.com>
 * @package App\Dto
 */
class PostParams extends QueryParameters
{
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
}
