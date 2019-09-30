<?php

namespace App\Tests\Unit\Repository;

use App\Exception\EntityDoesNotExistException;
use App\Repository\AbstractRepository;
use App\Tests\Shared\Dummy\DummyEntity;
use App\Util\RepositoryUtilInterface;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetadata;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

class AbstractRepositoryTest extends TestCase
{
    const ENTITY_CLASS_EXISTS = DummyEntity::class;
    const ENTITY_CLASS_DOES_NOT_EXIST = '__NO_ENTITY__';

    private $abstractRepository;
    private $repositoryUtil;
    private $manager;
    private $registry;

    protected function setUp()
    {
        $this->prophesizeRegistry();
        $this->prophesizeRepositoryUtil();
    }

    private function prophesizeRegistry()
    {
        $classMetadata = $this->prophesize(ClassMetadata::class);

        $this->manager = $this->prophesize(EntityManagerInterface::class);
        $this->manager
            ->getClassMetadata(Argument::any())
            ->willReturn($classMetadata->reveal());

        $this->registry = $this->prophesize(ManagerRegistry::class);
        $this->registry
            ->getManagerForClass(Argument::any())
            ->willReturn($this->manager->reveal());
    }

    private function prophesizeRepositoryUtil()
    {
        $this->repositoryUtil = $this->prophesize(RepositoryUtilInterface::class);
    }

    public function test_getEntityClass()
    {
        $this->repositoryUtil
            ->convertRepositoryClassIntoEntityClass(Argument::any())
            ->willReturn(self::ENTITY_CLASS_EXISTS);

        $this->abstractRepository = $this->getMockForAbstractClass(
            AbstractRepository::class,
            [
                $this->registry->reveal(),
                $this->repositoryUtil->reveal(),
            ]
        );

        $entityClass = $this->abstractRepository->getEntityClass();

        $this->assertSame(self::ENTITY_CLASS_EXISTS, $entityClass);
    }

    public function test_getEntityClass_returns_an_exception_if_attached_entity_class_does_not_exist()
    {
        $this->repositoryUtil
            ->convertRepositoryClassIntoEntityClass(Argument::any())
            ->willReturn(self::ENTITY_CLASS_DOES_NOT_EXIST);

        $this->expectException(EntityDoesNotExistException::class);

        $this->abstractRepository = $this->getMockForAbstractClass(
            AbstractRepository::class,
            [
                $this->registry->reveal(),
                $this->repositoryUtil->reveal(),
            ]
        );
    }
}