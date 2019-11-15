<?php declare(strict_types=1);

namespace App\Util\Example;

class Fibonacci03 implements FibonacciInterface
{
    /**
     * {@inheritdoc}
     */
    public function rank(int $n, int $a = 0, int $b = 1): int
    {
        // Terminal recursive algorithm.

        return ($n > 0) ? $this->rank($n - 1, $b, $a + $b) : $a;
    }
}
