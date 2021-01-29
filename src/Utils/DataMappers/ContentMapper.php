<?php

namespace App\Utils\DataMappers;

use App\Dto\ContentDto;
use App\Dto\PostDto;
use App\Entity\Content;
use App\Entity\Post;

/**
 * Data mapper for content
 *
 * @author Konstantin Laktionov <Starternh@gmail.com>
 * @package App\Utils\DataMappers
 */
class ContentMapper
{
    /**
     * Converts content DTO to content entities
     *
     * @param ContentDto[] $contentDto
     *
     * @return Content[]
     */
    public function toEntities(array $contentDto): array
    {
        $content = [];

        foreach ($contentDto as $contentDtoItem) {
            $contentItem = (new Content())
                ->setId($contentDtoItem->getId())
                ->setImageId($contentDtoItem->getImage())
                ->setBody($contentDtoItem->getBody())
                ->setType($contentDtoItem->getContentType())
                ->setPosition($contentDtoItem->getPosition());
            $content[] = $contentItem;
        }

        return $content;
    }

    /**
     * Converts content entities to DTO
     *
     * @param Content[] $content
     *
     * @return ContentDto[]
     */
    public function toContentDto(array $content): array
    {
        $contentDto = [];

        foreach ($content as $contentItem) {
            $contentDtoItem = (new ContentDto())
                ->setId($contentItem->getId())
                ->setImage($contentItem->getImageId())
                ->setBody($contentItem->getBody())
                ->setContentType($contentItem->getType())
                ->setPosition($contentItem->getPosition());

            $contentDto[] = $contentDtoItem;
        }

        return $contentDto;
    }

    /**
     * @param Post $post
     * @param PostDto $postDto
     *
     * @return array
     */
    public function updateContent(Post $post, PostDto $postDto): array
    {
        $contentMap = [];
        foreach ($post->getContent() as $contentItem) {
            $contentMap[(string)$contentItem->getId()] = $contentItem;
        }

        $content = [];
        foreach ($postDto->getContent() as $contentItem) {
            if (array_key_exists((string)$contentItem->getId(), $contentMap)) {
                $updatingContent = $contentMap[(string)$contentItem->getId()];
            } else {
                $updatingContent = (new Content())->setId($contentItem->getId());
            }

            $updatingContent
                ->setType($contentItem->getContentType())
                ->setBody($contentItem->getBody())
                ->setPosition($contentItem->getPosition())
                ->setImageId($contentItem->getImage());

            $content[] = $updatingContent;
        }

        return $content;
    }
}
