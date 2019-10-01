<?php

namespace App\Util;

class Fibonacci01Util implements FibonacciUtilInterface
{
    /**
     * {@inheritdoc}
     */
    public function rank(int $n): int
    {
        // Naive recursive algorithm.

        if ($n <= 1) {
            return $n;
        }

        return $this->rank($n - 1) + $this->rank($n - 2);
    }
}