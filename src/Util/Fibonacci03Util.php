<?php

namespace App\Util;

class Fibonacci03Util implements FibonacciUtilInterface
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