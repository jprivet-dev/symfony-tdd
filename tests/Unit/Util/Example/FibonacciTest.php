<?php

namespace App\Tests\Unit\Util\Example;

use App\Tests\TestCase;
use App\Util\Fibonacci01;
use App\Util\Fibonacci02;
use App\Util\Fibonacci03;
use App\Util\Fibonacci04;

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
        return [
            [0, 0],
            [1, 1],
            [2, 1],
            [3, 2],
            [4, 3],
            [5, 5],
            [6, 8],
            [7, 13],
            [8, 21],
            [9, 34],
            [10, 55],
            [11, 89],
            [12, 144],
            //[20, 6765], // Can be used to detect an error with Fibonacci04
        ];
    }
}
