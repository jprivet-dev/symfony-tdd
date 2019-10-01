<?php

namespace App\Util;

class Fibonacci02Util implements FibonacciUtilInterface
{
    /**
     * {@inheritdoc}
     */
    public function rank(int $n): int
    {
        // Linear algorithm.

        $i = 0;
        $j = 1;

        for ($k = 0; $k < $n; $k++) {
            $temp = $i + $j;
            $i = $j;
            $j = $temp;
        }

        return $i;
    }
}