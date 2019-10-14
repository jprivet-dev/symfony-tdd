<?php

namespace App\Util\Example;

/*
 * @see https://www.php.net/manual/en/language.oop5.abstract.php
 */
abstract class AbstractClassExample
{
    // Force Extending class to define this method
    abstract protected function getValue(): string;

    // Common method
    public function printOut(): string
    {
        return $this->getValue();
    }
}