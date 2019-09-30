<?php

namespace App\Tests\Unit\Repository;

use App\Repository\AbstractRepository;
use App\Tests\Shared\Models\Entity\Dummy;
use App\Tests\Shared\Models\Repository\DummyRepository;
use App\Tests\Shared\Models\Repository\DummyWithoutEntityRepository;
use App\Util\ClassUtilInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetadata;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Symfony\Bridge\Doctrine\ManagerRegistry;

class AbstractRepositoryTest extends TestCase
{
    const REPOSITORY_CLASS_WITH_ENTITY = DummyRepository::class;
    const ENTITY_CLASS = Dummy::class;

    const REPOSITORY_CLASS_WITHOUT_ENTITY = DummyWithoutEntityRepository::class;
    const ENTITY_CLASS_EMPTY = '';

    public function test_repository_has_entity()
    {
        $repositoryClass = self::REPOSITORY_CLASS_WITH_ENTITY;
        $entityClass = self::ENTITY_CLASS;

        $registry = $this->prophesizeRegistry($entityClass);
        $classUtil = $this->prophesizeClassUtil($repositoryClass, $entityClass);

        $abstractRepository = $this->getAbstracRepository($registry, $classUtil);

        $this->markTestIncomplete();
    }

    private function prophesizeClassUtil(string $repositoryClass, string $entityClass)
    {
        $classUtil = $this->prophesize(ClassUtilInterface::class);

        $classUtil
            ->get(Argument::any())
            ->willReturn($repositoryClass);

        $classUtil
            ->exists($entityClass)
            ->willReturn(true);

        return $classUtil;
    }

    private function prophesizeRegistry(string $entityClass)
    {
        $classMetadata = new ClassMetadata($entityClass);

        $manager = $this->prophesize(EntityManagerInterface::class);
        $manager
            ->getClassMetadata($entityClass)
            ->willReturn($classMetadata);

        $registry = $this->prophesize(ManagerRegistry::class);
        $registry
            ->getManagerForClass($entityClass)
            ->willReturn($manager->reveal());

        return $registry;
    }

    private function getAbstracRepository($registry, $classUtil)
    {
        return $this->getMockForAbstractClass(
            AbstractRepository::class,
            [
                $registry->reveal(),
                $classUtil->reveal()
            ]
        );
    }
}