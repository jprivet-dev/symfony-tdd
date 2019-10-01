<?php

namespace App\Tests\Unit\Util;

use App\Util\FibonacciVersion01Util;
use App\Util\FibonacciVersion02Util;
use App\Util\FibonacciVersion03Util;
use App\Util\FibonacciVersion04Util;
use PHPUnit\Framework\TestCase;

class FibonacciUtilTest extends TestCase
{
    private $fibonacciVersion01Util;
    private $fibonacciVersion02Util;
    private $fibonacciVersion03Util;
    private $fibonacciVersion04Util;

    protected function setUp()
    {
        $this->fibonacciVersion01Util = new FibonacciVersion01Util();
        $this->fibonacciVersion02Util = new FibonacciVersion02Util();
        $this->fibonacciVersion03Util = new FibonacciVersion03Util();
        $this->fibonacciVersion04Util = new FibonacciVersion04Util();
    }

    /**
     * @dataProvider termProvider
     */
    public function test_all_versions(int $n, int $expectedTerm)
    {
        $this->assertSame($expectedTerm, $this->fibonacciVersion01Util->rank($n));
        $this->assertSame($expectedTerm, $this->fibonacciVersion02Util->rank($n));
        $this->assertSame($expectedTerm, $this->fibonacciVersion03Util->rank($n));
        $this->assertSame($expectedTerm, $this->fibonacciVersion04Util->rank($n));
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
        ];
    }
}