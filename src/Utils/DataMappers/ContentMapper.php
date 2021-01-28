<?php

namespace App\Utils\DataMappers;

use App\Dto\ContentDto;
use App\Entity\Content;

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
                ->setType($contentDtoItem->getType())
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
                ->setType($contentItem->getType())
                ->setPosition($contentItem->getPosition());

            $contentDto[] = $contentDtoItem;
        }

        return $contentDto;
    }
}
