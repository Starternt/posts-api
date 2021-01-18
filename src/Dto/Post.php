<?php

namespace App\Dto;

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
     * @return string
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @param string $id
     *
     * @return Post
     */
    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }
}