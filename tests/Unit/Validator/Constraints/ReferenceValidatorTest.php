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

    public function testInvalidConstraint()
    {
        $this->expectException(UnexpectedTypeException::class);
        $constraint = $this->getMockForAbstractClass(Constraint::class);
        $this->validator->validate('abc123', $constraint);
    }

    public function testInvalidValue()
    {
        $this->expectException(UnexpectedValueException::class);
        $this->validator->validate(123, new Reference());
    }

    public function testValidValueIsNullOrEmpty()
    {
        $this->validator->validate(null, new Reference());
        $this->assertNoViolation();

        $this->validator->validate('', new Reference());
        $this->assertNoViolation();
    }

    public function testValidString()
    {
        $this->validator->validate('abc123', new Reference());
        $this->assertNoViolation();
    }

    public function testInvalidString()
    {
        $reference = new Reference([
            'message' => 'myMessage',
        ]);

        $this->validator->validate('abc_123', $reference);

        $this->buildViolation('myMessage')
            ->setParameter('{{ string }}', 'abc_123')
            ->assertRaised();
    }
}
