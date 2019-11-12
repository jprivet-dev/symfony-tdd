<?php

namespace App\Util\Example;

class Fibonacci01 implements FibonacciInterface
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
