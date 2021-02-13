<?php

namespace App\Utils\DataMappers;

use App\Dto\PostDto;
use App\Dto\UserDto;
use App\Entity\Post;
use App\Entity\User;
use Exception;

/**
 * Data mapper for posts
 *
 * @author Konstantin Laktionov <Starternh@gmail.com>
 * @package App\Utils\DataMappers
 */
class PostMapper
{
    /**
     * Data mapper for content
     *
     * @var ContentMapper
     */
    protected $contentMapper;

    /**
     * Constructor
     *
     * @param ContentMapper $contentMapper
     */
    public function __construct(ContentMapper $contentMapper)
    {
        $this->contentMapper = $contentMapper;
    }

    /**
     * Convert DTO to post entity
     *
     * @param PostDto $postDto
     * @param User $user
     *
     * @return Post
     */
    public function toEntity(PostDto $postDto, User $user): Post
    {
        return (new Post())
            ->setId($postDto->getId())
            ->setTitle($postDto->getTitle())
            ->setCreatedBy($user)
            ->setRating($postDto->getRating())
            ->setCreatedAt($postDto->getCreatedAt())
            ->setUpdatedAt($postDto->getUpdatedAt())
            ->setContent($this->contentMapper->toEntities($postDto->getContent()));
    }

    /**
     * Convert post entity to DTO
     *
     * @param Post $post
     *
     * @return PostDto
     */
    public function toDto(Post $post): PostDto
    {
        $createdBy = (new UserDto())->setId($post->getCreatedBy()->getId());

        return (new PostDto())
            ->setId($post->getId())
            ->setTitle($post->getTitle())
            ->setCreatedBy($createdBy)
            ->setRating($post->getRating())
            ->setCreatedAt($post->getCreatedAt())
            ->setUpdatedAt($post->getUpdatedAt())
            ->setContent($this->contentMapper->toContentDto($post->getContent()));
    }

    /**
     * Update post entity fields
     *
     * @param Post $post
     * @param PostDto $postDto
     *
     * @throws Exception
     */
    public function updatePost(Post $post, PostDto $postDto)
    {
        $post->setTitle($postDto->getTitle());
        $post->setContent($this->contentMapper->updateContent($post, $postDto));
    }
}
