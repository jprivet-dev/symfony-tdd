<?php

namespace App\Tests\Unit;

use App\Repository\AbstractRepository;
use App\Util\RepositoryUtilInterface;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetadata;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

class AbstractRepositoryTest extends TestCase
{
    const ENTITY_CLASS = 'ENTITY_CLASS';
    private $abstractRepository;

    protected function setUp()
    {
        $registry = $this->prophesizeRegistry();
        $repositoryUtil = $this->prophesizeRepositoryUtil();

        $this->abstractRepository = $this->getMockForAbstractClass(
            AbstractRepository::class,
            [
                $registry->reveal(),
                $repositoryUtil->reveal(),
            ]
        );
    }

    private function prophesizeRegistry()
    {
        $classMetadata = $this->prophesize(ClassMetadata::class);

        $manager = $this->prophesize(EntityManagerInterface::class);
        $manager
            ->getClassMetadata(Argument::any())
            ->willReturn($classMetadata->reveal());

        $registry = $this->prophesize(ManagerRegistry::class);
        $registry
            ->getManagerForClass(Argument::any())
            ->willReturn($manager->reveal());

        return $registry;
    }

    private function prophesizeRepositoryUtil()
    {
        $repositoryUtil = $this->prophesize(RepositoryUtilInterface::class);
        $repositoryUtil
            ->convertRepositoryClassIntoEntityClass(Argument::any())
            ->willReturn(self::ENTITY_CLASS);

        return $repositoryUtil;
    }

    public function test_convertRepositoryClassIntoEntityClass()
    {
        $this->markTestIncomplete();
    }

    public function test_getTheEntityClassAttachedToTheCurrentRepositoryClass()
    {
        $entityClass = $this->abstractRepository->getTheEntityClassAttachedToTheCurrentRepositoryClass();
        $this->assertSame(self::ENTITY_CLASS, $entityClass);
    }
}