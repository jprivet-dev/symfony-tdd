<?php

namespace App\Tests\Unit\Repository;

use App\Exception\EntityDoesNotExistException;
use App\Repository\AbstractRepository;
use App\Tests\Shared\Dummy\DummyEntity;
use App\Tests\Shared\Models\Entity\Dummy;
use App\Tests\Shared\Models\Repository\DummyRepository;
use App\Tests\Shared\Models\Repository\DummyWithoutEntityRepository;
use App\Util\RepositoryUtilInterface;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetadata;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

class AbstractRepositoryTest extends TestCase
{
    const ENTITY = Dummy::class;
    const REPOSITORY_WITH_ENTITY = DummyRepository::class;

    const REPOSITORY_WITHOUT_ENTITY = DummyWithoutEntityRepository::class;

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

    private function getAbstracRepository(string $repositoryClass)
    {
        $registry = $this->prophesizeRegistry();
        return new $repositoryClass($registry->reveal());
    }

    public function test_getEntityClass()
    {
        $abstractRepository = $this->getAbstracRepository(self::ENTITY_CLASS_EXISTS);
        $entityClass = $abstractRepository->getEntityClass();
        $this->assertSame(self::ENTITY_CLASS_EXISTS, $entityClass);
    }

    public function test_getEntityClass_returns_an_exception_if_attached_entity_class_does_not_exist()
    {
        $this->expectException(EntityDoesNotExistException::class);
        $this->getAbstracRepository(self::ENTITY_CLASS_DOES_NOT_EXIST);
    }
}