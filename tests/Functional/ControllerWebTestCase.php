<?php declare(strict_types=1);

namespace App\Tests\Functional;

use App\Tests\Shared\Functional\RealBrowserWebTestCase;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;

abstract class ControllerWebTestCase extends RealBrowserWebTestCase
{
    use RefreshDatabaseTrait;
}