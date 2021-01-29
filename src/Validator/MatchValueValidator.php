<?php

namespace App\Validator;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

/**
 * @author Konstantin Laktionov <Starternh@gmail.com>
 * @package App\Validator
 */
class MatchValueValidator extends ConstraintValidator
{
    /**
     * @var RequestStack
     */
    private $stack;

    /**
     * @var PropertyAccessorInterface
     */
    private $accessor;

    /**
     * @param RequestStack $stack
     * @param PropertyAccessorInterface $accessor
     */
    public function __construct(RequestStack $stack, PropertyAccessorInterface $accessor)
    {
        $this->stack = $stack;
        $this->accessor = $accessor;
    }

    /**
     * @param mixed $value
     * @param Constraint $constraint
     */
    public function validate($value, Constraint $constraint): void
    {
        if (!$constraint instanceof MatchValue) {
            throw new UnexpectedTypeException($constraint, MatchValue::class);
        }

        if (empty($value)) {
            return;
        }

        $expectedValue = $this->stack->getMasterRequest()->attributes->get($constraint->parameter);
        if (!empty($constraint->path)) {
            $expectedValue = $this->accessor->getValue($expectedValue, $constraint->path);
        }

        if ($value != $expectedValue) {
            $this->context
                ->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $expectedValue)
                ->setCode(MatchValue::ERROR_CODE)
                ->addViolation();
        }
    }
}