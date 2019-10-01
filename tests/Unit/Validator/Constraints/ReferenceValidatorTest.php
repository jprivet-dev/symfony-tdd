<?php

namespace App\Tests\Unit\Validator\Constraints;

use App\Validator\Constraints\Reference;
use App\Validator\Constraints\ReferenceValidator;
use Symfony\Component\Validator\Exception\UnexpectedValueException;
use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;

class ReferenceValidatorTest extends ConstraintValidatorTestCase
{
    protected function createValidator()
    {
        return new ReferenceValidator();
    }

    public function testStringIsValid()
    {
        $this->validator->validate('Abc123', new Reference());
        $this->assertNoViolation();
    }

    public function testExpectsStringCompatibleType()
    {
        $this->expectException(UnexpectedValueException::class);
        $this->validator->validate(new \stdClass(), new Reference());
    }
}