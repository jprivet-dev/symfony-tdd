<?php declare(strict_types=1);

namespace App\Tests\Shared\Functional;

use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;

abstract class ControllerWebTestCase extends RealBrowserWebTestCase
{
    use RefreshDatabaseTrait;
}