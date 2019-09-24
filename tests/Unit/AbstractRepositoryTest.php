<?php

namespace App\Tests\Unit;

use App\Repository\AbstractRepository;
use App\Util\RepositoryUtilInterface;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Common\Persistence\Mapping\ClassMetadata;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

class AbstractRepositoryTest extends TestCase
{
    private $abstractRepository;

    protected function setUp()
    {
        $repositoryUtil = $this->prophesize(RepositoryUtilInterface::class);
        $repositoryUtil
            ->convertRepositoryClassIntoEntityClass(Argument::any())
            ->willReturn('__ENTITY_CLASS__');

        $manager = $this->prophesize(EntityManagerInterface::class);

        $registry = $this->prophesize(ManagerRegistry::class);
        $registry
            ->getManagerForClass(Argument::any())
            ->willReturn($manager->reveal());

        $this->abstractRepository = $this->getMockForAbstractClass(
            AbstractRepository::class,
            [
                $registry->reveal(),
                $repositoryUtil->reveal(),
            ]
        );
    }

    public function test_convertRepositoryClassIntoEntityClass()
    {
        $this->markTestIncomplete();
    }
}