<?php

namespace App\Dto;

use DateTimeInterface;
use Reva2\JsonApi\Annotations\ApiResource;
use Reva2\JsonApi\Annotations\Id;
use Reva2\JsonApi\Annotations\Relationship;

/**
 * Post DTO
 *
 * @author Konstantin Laktionov <Starternh@gmail.com>
 * @package App\Dto
 *
 * @ApiResource(name="posts")
 */
class Post
{
    /**
     * Post ID
     *
     * @var string
     * @Id()
     */
    protected $id;

    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Length(
     *     max=250,
     *     maxMessage="Title can not be longer than {{limit}} characters."
     * )
     * @Attribute()
     */
    protected $title;

    /**
     * @var string
     * 
     */
    protected $createdBy;

    /**
     * @var int
     */
    protected $rating;

    /**
     * @var DateTimeInterface
     */
    protected $createdAt;

    /**
     * @var DateTimeInterface
     */
    protected $updatedAt;

    /**
     * @var Content[]
     * @Assert\Type(type="array")
     * @Assert\Valid(traverse=true)
     * @Relationship(
     *     type="App\Dto\Content[]"
     * )
     */
    protected $content;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     *
     * @return Post
     */
    public function setId(string $id): Post
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @return Post
     */
    public function setTitle(string $title): Post
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getCreatedBy(): string
    {
        return $this->createdBy;
    }

    /**
     * @param string $createdBy
     *
     * @return Post
     */
    public function setCreatedBy(string $createdBy): Post
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * @return int
     */
    public function getRating(): int
    {
        return $this->rating;
    }

    /**
     * @param int $rating
     *
     * @return Post
     */
    public function setRating(int $rating): Post
    {
        $this->rating = $rating;

        return $this;
    }

    /**
     * @return DateTimeInterface
     */
    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @param DateTimeInterface $createdAt
     *
     * @return Post
     */
    public function setCreatedAt(DateTimeInterface $createdAt): Post
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return DateTimeInterface
     */
    public function getUpdatedAt(): DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * @param DateTimeInterface $updatedAt
     *
     * @return Post
     */
    public function setUpdatedAt(DateTimeInterface $updatedAt): Post
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return Content[]|null
     */
    public function getContent(): ?array
    {
        return $this->content;
    }

    /**
     * @param Content[] $content
     *
     * @return Post
     */
    public function setContent(array $content): Post
    {
        $this->content = $content;

        return $this;
    }
}