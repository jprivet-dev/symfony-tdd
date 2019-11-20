<?php declare(strict_types=1);

namespace App\Tests\Shared\Fixtures;

use App\Entity\News;
use App\Tests\Shared\Exception\FixtureNotFoundException;

class FixturesDecorator
{
    private $fixtures;

    public function __construct(array $fixtures)
    {
        $this->fixtures = $fixtures;
    }

    public function get(string $id)
    {
        if (key_exists($id, $this->fixtures)) {
            return $this->fixtures[$id];
        }

        throw new FixtureNotFoundException($id);
    }

    public function news(string $id): News
    {
        return $this->get($id);
    }
}