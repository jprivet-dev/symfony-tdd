<?php declare(strict_types=1);

namespace App\Tests\Unit\Validator\Constraints;

use App\Tests\ConstraintValidatorTestCase;
use App\Validator\Constraints\Reference;
use App\Validator\Constraints\ReferenceValidator;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class ReferenceValidatorTest extends ConstraintValidatorTestCase
{
    protected function createValidator()
    {
        return new ReferenceValidator();
    }

    public function testInvalidConstraint()
    {
        $this->expectException(UnexpectedTypeException::class);

        // Arrange
        $constraint = $this->getMockForAbstractClass(Constraint::class);

        // Act
        $this->validator->validate('abc123', $constraint);
    }

    public function testInvalidValue()
    {
        $this->expectException(UnexpectedValueException::class);

        // Act
        $this->validator->validate(123, new Reference());
    }

    /**
     * @dataProvider validValueProvider
     * @param $value
     */
    public function testValidValue($value)
    {
        // Act
        $this->validator->validate($value, new Reference());

        // Assert
        $this->assertNoViolation();
    }

    public function validValueProvider()
    {
        yield [null];
        yield [''];
        yield ['abc123'];
    }

    public function testInvalidString()
    {
        // Arrange
        $reference = new Reference([
            'message' => 'myMessage',
        ]);

        // Act
        $this->validator->validate('abc_123', $reference);

        // Assert
        $this->buildViolation('myMessage')
            ->setParameter('{{ string }}', 'abc_123')
            ->assertRaised();
    }
}
