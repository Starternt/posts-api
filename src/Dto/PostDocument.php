<?php

namespace App\Dto;

use Reva2\JsonApi\Annotations\ApiDocument;
use Reva2\JsonApi\Annotations\Content;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * JSON API document that contains single post
 *
 * @author Konstantin Laktionov <Starternh@gmail.com>
 * @package App\Dto
 *
 * @ApiDocument()
 */
class PostDocument
{
    /**
     * @var PostDto
     * @Content(type="App\Dto\PostDto",
     *     loaders={
     *      @Reva2\JsonApi\Annotations\Loader(loader="App\Loader\PostLoader:create", group="CreatePost")
     *     })
     * @Assert\NotBlank()
     * @Assert\Valid()
     */
    public $data;
}
