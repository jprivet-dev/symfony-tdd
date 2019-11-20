<?php declare(strict_types=1);

namespace App\Tests\Shared\Exception;

use Nelmio\Alice\Throwable\Exception\FixtureNotFoundException as AliceFixtureNotFoundException;

final class FixtureNotFoundException extends AliceFixtureNotFoundException
{
}