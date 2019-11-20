<?php declare(strict_types=1);

namespace App\Tests\Shared\Fixtures;

trait FixturesTrait
{
    protected static $fixturesDecorator;

    protected static function fixtures(): FixturesDecorator
    {
        if (!static::$fixturesDecorator instanceof FixturesDecorator) {
            static::$fixturesDecorator = new FixturesDecorator(self::$fixtures);
        };

        return static::$fixturesDecorator;
    }
}