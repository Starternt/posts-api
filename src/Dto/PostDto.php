<?php

namespace App\Dto;

use App\Validator\MatchValue;
use DateTimeImmutable;
use DateTimeInterface;
use DateTimeZone;
use Exception;
use Ramsey\Uuid\Uuid;
use Reva2\JsonApi\Annotations\ApiResource;
use Reva2\JsonApi\Annotations\Attribute;
use Reva2\JsonApi\Annotations\Id;
use Reva2\JsonApi\Annotations\Relationship;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Post DTO
 *
 * @author Konstantin Laktionov <Starternh@gmail.com>
 * @package App\Dto
 *
 * @ApiResource(name="posts")
 */
class PostDto
{
    /**
     * Post ID
     *
     * @var string
     * @Id()
     * @Assert\NotBlank(groups={"UpdatePost"})
     * @MatchValue(parameter="id", groups={"UpdatePost"})
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
     * @var UserDto|null
     * @Relationship(type="App\Dto\UserDto")
     */
    protected $createdBy;

    /**
     * @var int
     */
    protected $rating = 0;

    /**
     * @var DateTimeInterface
     */
    protected $createdAt;

    /**
     * @var DateTimeInterface
     */
    protected $updatedAt;

    /**
     * @var ContentDto[]
     * @Assert\Type(type="array")
     * @Assert\Valid(traverse=true)
     * @Assert\Count(min="1", max="15")
     * @Relationship(
     *     type="App\Dto\ContentDto[]"
     * )
     */
    protected $content;

    /**
     * PostDto constructor.
     *
     * @throws Exception
     */
    public function __construct()
    {
        $dateTime = new DateTimeImmutable('now', new DateTimeZone('UTC'));
        $this->createdAt = $dateTime;
        $this->updatedAt = $dateTime;
        $this->id = Uuid::uuid4();
    }

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
     * @return PostDto
     */
    public function setId(string $id): PostDto
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
     * @return PostDto
     */
    public function setTitle(string $title): PostDto
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return UserDto|null
     */
    public function getCreatedBy(): ?UserDto
    {
        return $this->createdBy;
    }

    /**
     * @param UserDto|null $createdBy
     *
     * @return PostDto
     */
    public function setCreatedBy(?UserDto $createdBy): PostDto
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
     * @return PostDto
     */
    public function setRating(int $rating): PostDto
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
     * @return PostDto
     */
    public function setCreatedAt(DateTimeInterface $createdAt): PostDto
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
     * @return PostDto
     */
    public function setUpdatedAt(DateTimeInterface $updatedAt): PostDto
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return ContentDto[]|null
     */
    public function getContent(): ?array
    {
        return $this->content;
    }

    /**
     * @param ContentDto[] $content
     *
     * @return PostDto
     */
    public function setContent(array $content): PostDto
    {
        $this->content = $content;

        return $this;
    }
}