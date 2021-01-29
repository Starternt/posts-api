<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @author Konstantin Laktionov <Starternh@gmail.com>
 * @package App\Validator
 *
 * @Annotation
 */
class MatchValue extends Constraint
{
    const ERROR_CODE = '2752480d-0be8-4af3-9716-2ef021765061';

    /**
     * @var string
     */
    public $parameter;

    /**
     * @var string
     */
    public $path;

    /**
     * @var string
     */
    public $message = "Value should be equal to {{ value }}";
}