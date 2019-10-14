<?php

namespace App\Tests\Unit\Util\Example;

use App\Tests\TestCase;
use App\Util\Example\AbstractClassExample;

class AbstractClassExampleTest extends TestCase
{
    public function testPrintOutWithMockForAbstractClassMethod()
    {
        $abstract = $this->getMockForAbstractClass(AbstractClassExample::class);

        $abstract
            ->expects($this->once())
            ->method('getValue')
            ->willReturn('foo');

        $this->assertSame('foo', $abstract->printOut());
    }
}