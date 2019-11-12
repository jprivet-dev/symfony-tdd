<?php

namespace App\Util;

class Fibonacci04 implements FibonacciUtilInterface
{
    /**
     * {@inheritdoc}
     */
    public function rank(int $n): int
    {
        // "It does the job" algorithm.

        switch ($n) {
            case 1:
            case 2:
                return 1;
            case 3:
                return 2;
            case 4:
                return 3;
            case 5:
                return 5;
            case 6:
                return 8;
            case 7:
                return 13;
            case 8:
                return 21;
            case 9:
                return 34;
            case 10:
                return 55;
            case 11:
                return 89;
            case 12:
                return 144;
            default:
                return 0;
        }
    }
}
