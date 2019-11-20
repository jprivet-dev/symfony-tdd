<?php declare(strict_types=1);

namespace App\Tests\Shared\Fixtures;

use App\Entity\News;

class FixturesDecorator extends AbstractFixturesDecorator
{
    public function news(string $id): News
    {
        return $this->get($id);
    }
}