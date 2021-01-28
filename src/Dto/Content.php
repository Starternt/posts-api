<?php

namespace App\Dto;

use DateTimeInterface;
use Reva2\JsonApi\Annotations\ApiResource;
use Reva2\JsonApi\Annotations\Id;
use Reva2\JsonApi\Annotations\Relationship;

/**
 * Content DTO
 *
 * @author Konstantin Laktionov <Starternh@gmail.com>
 * @package App\Dto
 *
 * @ApiResource(name="content")
 */
class Content
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
     * @var Post
     * @Assert\NotBlank()
     * @Relationship(
     *     type="App\Dto\Post"
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
     * @var string
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
     * @Attribute()
     */
    protected $position = 1;

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
     * @return Content
     */
    public function setId(string $id): Content
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return Post|null
     */
    public function getPost(): ?Post
    {
        return $this->post;
    }

    /**
     * @param Post $post
     *
     * @return Content
     */
    public function setPost(Post $post): Content
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
     * @return Content
     */
    public function setType(string $type): Content
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
     * @return Content
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
     * @param string $body
     *
     * @return Content
     */
    public function setBody(string $body): Content
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
     * @return Content
     */
    public function setPosition(int $position): Content
    {
        $this->position = $position;

        return $this;
    }
}