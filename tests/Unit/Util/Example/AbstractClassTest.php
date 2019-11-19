<?php declare(strict_types=1);

namespace App\Tests\Unit\Util\Example;

use App\Tests\Unit\TestCase;
use App\Util\Example\AbstractClass;

class AbstractClassTest extends TestCase
{
    /**
     * @see https://phpunit.readthedocs.io/en/8.4/test-doubles.html#mocking-traits-and-abstract-classes
     */
    public function testConcreteMethodWithMockForAbstractClassMethod()
    {
        // Arrange
        $stub = $this->getMockForAbstractClass(AbstractClass::class);

        $stub
            ->expects($this->once())
            ->method('abstractMethod')
            ->willReturn('foo');

        // Act
        $result = $stub->concreteMethod();

        // Assert
        $this->assertSame('foo', $result);
    }

    /**
     * @see https://mnapoli.fr/anonymous-classes-in-tests/
     */
    public function testConcreteMethodWithAnonymousClass()
    {
        // Arrange
        $class = new class() extends AbstractClass
        {
            protected function abstractMethod(): string
            {
                return 'foo';
            }
        };

        // Act
        $result = $class->concreteMethod();

        // Assert
        $this->assertSame('foo', $result);
    }

    public function testConcreteMethodWithDummyClass()
    {
        // Arrange
        $dummy = new Dummy();

        // Act
        $result = $dummy->concreteMethod();

        // Assert
        $this->assertSame('foo', $result);
    }
}
