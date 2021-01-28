<?php

namespace App\Schema;

use App\Dto\ContentDto;
use Neomerx\JsonApi\Schema\SchemaProvider;

/**
 * JSON API schema for content
 *
 * @author Konstantin Laktionov <Starternh@gmail.com>
 * @package App\Schema
 */
class ContentSchema extends SchemaProvider
{
    protected $resourceType = 'content';

    /**
     * @param ContentDto $resource
     *
     * @return string
     */
    public function getId($resource): string
    {
        return (string)$resource->getId();
    }

    /**
     * @param ContentDto $resource
     *
     * @return array
     */
    public function getAttributes($resource): array
    {
        return [
            'type'     => $resource->getType(),
            'body'     => $resource->getBody(),
            'position' => $resource->getPosition(),
        ];
    }

    // /** TODO */
    //  * @inheritdoc
    //  */
    // public function getRelationships($resource, $isPrimary, array $includeRelationships): array
    // {
    //     /* @var $resource ContentDto */
    //     $relationships = [];
    //     if (in_array('image', $includeRelationships)) {
    //         $relationships = [
    //             'image' => [self::DATA => $resource->getImage()],
    //         ];
    //     }
    //
    //     return $relationships;
    // }
}