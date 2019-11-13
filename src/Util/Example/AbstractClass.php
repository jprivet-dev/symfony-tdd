<?php declare(strict_types=1);

namespace App\Util\Example;

/**
 * @see https://www.php.net/manual/en/language.oop5.abstract.php
 */
abstract class AbstractClass
{
    // Force Extending class to define this method
    abstract protected function abstractMethod(): string;

    // Common method
    public function concreteMethod(): string
    {
        return $this->abstractMethod();
    }
}
