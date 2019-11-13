<?php declare(strict_types=1);

namespace App\Util\Example;

interface FibonacciInterface
{
    /**
     * Returns the rank term `n` from the Fibonacci sequence.
     *
     * @param int $n
     * @return int
     */
    public function rank(int $n): int;
}
