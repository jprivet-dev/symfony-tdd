<?php declare(strict_types=1);

namespace App\Tests\Unit\Util\Example;

use App\Util\Example\AbstractClass;

class Dummy extends AbstractClass
{
    protected function abstractMethod(): string
    {
        return 'foo';
    }
}