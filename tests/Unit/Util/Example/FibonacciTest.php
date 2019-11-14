<?php declare(strict_types=1);

namespace App\Tests\Unit\Util\Example;

use App\Tests\TestCase;
use App\Util\Example\Fibonacci01;
use App\Util\Example\Fibonacci02;
use App\Util\Example\Fibonacci03;
use App\Util\Example\Fibonacci04;

class FibonacciTest extends TestCase
{
    private $fibonacciList = [];

    protected function setUp(): void
    {
        $this->fibonacciList = [
            new Fibonacci01(),
            new Fibonacci02(),
            new Fibonacci03(),
            new Fibonacci04(),
        ];
    }

    /**
     * @dataProvider termProvider
     */
    public function testChecksAllVersionsWithAllTerms(int $n, int $expectedTerm)
    {
        foreach ($this->fibonacciList as $fibonacci) {
            // Act
            $term = $fibonacci->rank($n);

            // Assert
            $message = sprintf('Failed asserting with the class "%s" and the term "%s".', get_class($fibonacci), $n);
            $this->assertSame($expectedTerm, $term, $message);
        }
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
