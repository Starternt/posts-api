<?php

namespace App\Dto;

use DateTimeInterface;
use Ramsey\Uuid\Uuid;
use Reva2\JsonApi\Annotations\ApiResource;
use Reva2\JsonApi\Annotations\Id;
use Reva2\JsonApi\Annotations\Relationship;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Content DTO
 *
 * @author Konstantin Laktionov <Starternh@gmail.com>
 * @package App\Dto
 *
 * @ApiResource(name="content")
 */
class ContentDto
{
    const TYPE_TEXT = 'text';
    const TYPE_IMAGE = 'image';
    const TYPE_VIDEO = 'video';

    /**
     * Content ID
     *
     * @var string
     * @Id()
     */
    protected $id;

    /**
     * @var PostDto
     * @Assert\NotBlank(groups={"UpdatePost"})
     * @Relationship(
     *     type="App\Dto\PostDto"
     * )
     */
    protected $post;

    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Choice(
     *     choices={"text","image","video"}, message="Invalid content type."
     * )
     * @Attribute()
     */
    protected $type = self::TYPE_TEXT;

    /**
     * @var
     * 
     */
    protected $image;

    /**
     * @var string|null
     * @Assert\Length(
     *     max=5000,
     *     maxMessage="Body can not be longer than {{limit}} characters."
     * )
     * @Attribute()
     */
    protected $body;

    /**
     * @var int
     * @Assert\NotBlank()
     * @Assert\Range(min="1", max="15")
     * @Attribute()
     */
    protected $position = 1;

    /**
     * ContentDto constructor.
     */
    public function __construct()
    {
        $this->id = Uuid::uuid4();
    }

    /**
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @param string $id
     *
     * @return ContentDto
     */
    public function setId(string $id): ContentDto
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return PostDto|null
     */
    public function getPost(): ?PostDto
    {
        return $this->post;
    }

    /**
     * @param PostDto $post
     *
     * @return ContentDto
     */
    public function setPost(PostDto $post): ContentDto
    {
        $this->post = $post;

        return $this;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     *
     * @return ContentDto
     */
    public function setType(string $type): ContentDto
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     *
     * @return ContentDto
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return string
     */
    public function getBody(): ?string
    {
        return $this->body;
    }

    /**
     * @param string|null $body
     *
     * @return ContentDto
     */
    public function setBody(?string $body): ContentDto
    {
        $this->body = $body;

        return $this;
    }

    /**
     * @return int
     */
    public function getPosition(): int
    {
        return $this->position;
    }

    /**
     * @param int $position
     *
     * @return ContentDto
     */
    public function setPosition(int $position): ContentDto
    {
        $this->position = $position;

        return $this;
    }
}