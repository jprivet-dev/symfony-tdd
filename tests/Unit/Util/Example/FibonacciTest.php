<?php

namespace App\Tests\Unit\Util\Example;

use App\Tests\TestCase;
use App\Util\Example\Fibonacci01;
use App\Util\Example\Fibonacci02;
use App\Util\Example\Fibonacci03;
use App\Util\Example\Fibonacci04;

class FibonacciTest extends TestCase
{
    private $fibonacci01;
    private $fibonacci02;
    private $fibonacci03;
    private $fibonacci04;

    protected function setUp(): void
    {
        $this->fibonacci01 = new Fibonacci01();
        $this->fibonacci02 = new Fibonacci02();
        $this->fibonacci03 = new Fibonacci03();
        $this->fibonacci04 = new Fibonacci04();
    }

    /**
     * @dataProvider termProvider
     */
    public function testCheckingAllVersions(int $n, int $expectedTerm)
    {
        $this->assertSame($expectedTerm, $this->fibonacci01->rank($n));
        $this->assertSame($expectedTerm, $this->fibonacci02->rank($n));
        $this->assertSame($expectedTerm, $this->fibonacci03->rank($n));
        $this->assertSame($expectedTerm, $this->fibonacci04->rank($n));
    }

    public function termProvider()
    {
            yield [0, 0];
            yield [1, 1];
            yield [2, 1];
            yield [3, 2];
            yield [4, 3];
            yield [5, 5];
            yield [6, 8];
            yield [7, 13];
            yield [8, 21];
            yield [9, 34];
            yield [10, 55];
            yield [11, 89];
            yield [12, 144];
            //yield [20, 6765]; // Can be used to detect an error with Fibonacci04
    }
}
