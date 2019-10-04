<?php

namespace App\Tests\Unit\Util;

use App\Util\Fibonacci01Util;
use App\Util\Fibonacci02Util;
use App\Util\Fibonacci03Util;
use App\Util\Fibonacci04Util;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class FibonacciUtilTest extends TestCase
{
    private $fibonacci01Util;
    private $fibonacci02Util;
    private $fibonacci03Util;
    private $fibonacci04Util;

    protected function setUp(): void
    {
        $this->fibonacci01Util = new Fibonacci01Util();
        $this->fibonacci02Util = new Fibonacci02Util();
        $this->fibonacci03Util = new Fibonacci03Util();
        $this->fibonacci04Util = new Fibonacci04Util();
    }

    /**
     * @dataProvider termProvider
     */
    public function testCheckingAllVersions(int $n, int $expectedTerm)
    {
        $this->assertSame($expectedTerm, $this->fibonacci01Util->rank($n));
        $this->assertSame($expectedTerm, $this->fibonacci02Util->rank($n));
        $this->assertSame($expectedTerm, $this->fibonacci03Util->rank($n));
        $this->assertSame($expectedTerm, $this->fibonacci04Util->rank($n));
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
            //[20, 6765], // Can be used to detect an error with Fibonacci04Util
        ];
    }
}
