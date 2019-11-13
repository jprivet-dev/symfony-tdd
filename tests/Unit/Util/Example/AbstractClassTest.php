<?php declare(strict_types=1);

namespace App\Tests\Unit\Util\Example;

use App\Tests\TestCase;
use App\Util\Example\AbstractClass;

class AbstractClassTest extends TestCase
{
    /**
     * @see https://phpunit.readthedocs.io/en/8.4/test-doubles.html#mocking-traits-and-abstract-classes
     */
    public function testConcreteMethodWithMockForAbstractClassMethod()
    {
        $stub = $this->getMockForAbstractClass(AbstractClass::class);

        $stub
            ->expects($this->once())
            ->method('abstractMethod')
            ->willReturn('foo');

        $this->assertSame('foo', $stub->concreteMethod());
    }

    /**
     * @see https://mnapoli.fr/anonymous-classes-in-tests/
     */
    public function testConcreteMethodWithAnonymousClass()
    {
        $class = new class() extends AbstractClass {
            protected function abstractMethod(): string
            {
                return 'foo';
            }
        };

        $this->assertSame('foo', $class->concreteMethod());
    }

    public function testConcreteMethodWithDummyClass()
    {
        $dummy = new Dummy();
        $this->assertSame('foo', $dummy->concreteMethod());
    }
}

class Dummy extends AbstractClass
{
    protected function abstractMethod(): string
    {
        return 'foo';
    }
}
