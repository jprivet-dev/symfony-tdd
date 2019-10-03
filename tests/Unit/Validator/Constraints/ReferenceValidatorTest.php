<?php

namespace App\Tests\Unit\Validator\Constraints;

use App\Validator\Constraints\Reference;
use App\Validator\Constraints\ReferenceValidator;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;
use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;

class ReferenceValidatorTest extends ConstraintValidatorTestCase
{
    protected function createValidator()
    {
        return new ReferenceValidator();
    }

    public function testReturnsAnExceptionIfConstraintIsNotAnInstanceOfReference()
    {
        $this->expectException(UnexpectedTypeException::class);
        $constraint = $this->getMockForAbstractClass(Constraint::class);
        $this->validator->validate('abc123', $constraint);
    }

    public function testReturnsAnExceptionIfValueIsNotAString()
    {
        $this->expectException(UnexpectedValueException::class);
        $this->validator->validate(123, new Reference());
    }

    public function testNoActionIfValueIsNullOrEmpty()
    {
        $this->validator->validate(null, new Reference());
        $this->assertNoViolation();

        $this->validator->validate('', new Reference());
        $this->assertNoViolation();
    }

    public function testStringIsValid()
    {
        $this->validator->validate('abc123', new Reference());
        $this->assertNoViolation();
    }

    public function testStringIsInvalid()
    {
        $reference = new Reference([
            'message' => 'myMessage',
        ]);

        $this->validator->validate('abc_123', $reference);

        $this->buildViolation('myMessage')
            ->setParameter('{{ string }}', 'abc_123')
            ->assertRaised();
    }

    public function testExpectsStringCompatibleType()
    {
        $this->expectException(UnexpectedValueException::class);
        $this->validator->validate(new \stdClass(), new Reference());
    }
}
