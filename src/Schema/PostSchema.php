<?php

namespace App\Schema;

use App\Dto\PostDto;
use Neomerx\JsonApi\Schema\SchemaProvider;

/**
 * JSON API schema for a post
 *
 * @author Konstantin Laktionov <Starternh@gmail.com>
 * @package App\Schema
 */
class PostSchema extends SchemaProvider
{
    protected $resourceType = 'posts';

    /**
     * @param PostDto $resource
     *
     * @return string
     */
    public function getId($resource): string
    {
        return (string)$resource->getId();
    }

    /**
     * @param PostDto $resource
     *
     * @return array
     */
    public function getAttributes($resource): array
    {
        return [
            'title'     => $resource->getTitle(),
            'rating'    => $resource->getRating(),
            'createdAt' => $resource->getCreatedAt()->format(DATE_ATOM),
            'updatedAt' => $resource->getUpdatedAt()->format(DATE_ATOM),
        ];
    }

    /**
     * @inheritdoc
     */
    public function getRelationships($resource, $isPrimary, array $includeRelationships): array
    {
        /* @var $resource PostDto */
        $relationships = [];
        if (in_array('createdBy', $includeRelationships)) {
            $relationships = [
                'createdBy' => [self::DATA => $resource->getCreatedBy()],
            ];
        }

        if (in_array('content', $includeRelationships)) {
            $relationships = [
                'content' => [self::DATA => $resource->getContent()],
            ];
        }

        return $relationships;
    }
}