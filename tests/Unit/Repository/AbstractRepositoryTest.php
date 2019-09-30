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

    protected function setUp()
    {
    }

    private function prophesizeRegistry(string $entityClass)
    {
        $classMetadata = $this->prophesize(ClassMetadata::class);

        /*
         * Value of `$classMetadata->name` is used for `$class->name`.
         *
         * @see vendor/doctrine/orm/lib/Doctrine/ORM/EntityRepository.php
         *
         * ```php
         *  public function __construct(EntityManagerInterface $em, Mapping\ClassMetadata $class)
         *  {
         *      $this->_entityName = $class->name; // <-- here
         *      $this->_em         = $em;
         *      $this->_class      = $class;
         *  }
         * ```
         */
        $classMetadata->name = $entityClass;

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

    private function prophesizeRepositoryUtil(string $entityClass)
    {
        $repositoryUtil = $this->prophesize(RepositoryUtilInterface::class);

        $repositoryUtil
            ->convertRepositoryClassIntoEntityClass(Argument::any())
            ->willReturn($entityClass);
    }

    private function getTestAbstracRepository(string $entityClass)
    {
        $registry = $this->prophesizeRegistry($entityClass);
        $repositoryUtil = $this->prophesizeRepositoryUtil($entityClass);

        return $this->getMockForAbstractClass(
            AbstractRepository::class,
            [
                $registry->reveal(),
                $repositoryUtil->reveal(),
            ]
        );
    }

    public function test_getEntityClass()
    {
        $abstractRepository = $this->getTestAbstracRepository(self::ENTITY_CLASS_EXISTS);
        $entityClass = $abstractRepository->getEntityClass();
        $this->assertSame(self::ENTITY_CLASS_EXISTS, $entityClass);
    }

    public function test_getEntityClass_returns_an_exception_if_attached_entity_class_does_not_exist()
    {
        $this->expectException(EntityDoesNotExistException::class);
        $this->getTestAbstracRepository(self::ENTITY_CLASS_DOES_NOT_EXIST);
    }
}