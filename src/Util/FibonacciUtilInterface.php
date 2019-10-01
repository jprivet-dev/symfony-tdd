<?php

namespace App\Util;

interface FibonacciUtilInterface
{
    /**
     * Returns the rank term `n` from the Fibonacci sequence.
     *
     * @param int $n
     * @return int
     */
    public function rank(int $n): int;
}
