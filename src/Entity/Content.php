<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Reva2\JsonApi\Annotations\Id;

/**
 * Content entity
 *
 * @author Konstantin Laktionov <Starternh@gmail.com>
 * @package App\Entity
 *
 * @ORM\Entity()
 * @ORM\Table(name="content")
 */
class Content
{
    /**
     * @var string
     *
     * @ORM\Id()
     * @ORM\Column(type="uuid")
     * @Id()
     */
    protected $id;

    /**
     * @var Post
     * @ORM\ManyToOne(targetEntity="Post", inversedBy="content")
     * @ORM\JoinColumn(name="postId", referencedColumnName="id")
     */
    protected $post;

    /**
     * @var string
     * @ORM\Column(type="string", name="type", columnDefinition="enum('text','image','video')")
     */
    protected $type;

    /**
     * @var string|null
     * @ORM\Column(type="string", name="imageId", length=36)
     */
    protected $imageId;

    /**
     * @var string|null
     * @ORM\Column(type="string")
     */
    protected $body;

    /**
     * @var int
     * @ORM\Column(type="integer", name="position")
     */
    protected $position;

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
     * @return Content
     */
    public function setId(string $id): Content
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return Post
     */
    public function getPost(): Post
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
     * @return string|null
     */
    public function getImageId(): ?string
    {
        return $this->imageId;
    }

    /**
     * @param string|null $imageId
     *
     * @return Content
     */
    public function setImageId(?string $imageId): Content
    {
        $this->imageId = $imageId;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getBody(): ?string
    {
        return $this->body;
    }

    /**
     * @param string|null $body
     *
     * @return Content
     */
    public function setBody(?string $body): Content
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
