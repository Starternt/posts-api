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
     * @var Post
     * @Content(type="App\Dto\Post")
     * @Assert\NotBlank()
     * @Assert\Valid()
     */
    public $data;
}
