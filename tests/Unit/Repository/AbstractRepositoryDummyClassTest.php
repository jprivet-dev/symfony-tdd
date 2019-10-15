<?php

namespace App\Tests\Unit\Repository;

use App\Exception\EntityDoesNotExistException;
use App\Repository\AbstractRepository;
use App\Tests\Shared\Models\Entity\Dummy;
use App\Tests\Shared\Models\Repository\DummyRepository;
use App\Tests\Shared\Models\Repository\DummyRepositoryWithoutEntity;
use App\Tests\TestCase;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetadata;
use Symfony\Bridge\Doctrine\ManagerRegistry;

class AbstractRepositoryDummyClassTest extends TestCase
{
    public function testRepositoryIntoEntityClassConverter()
    {
        $abstract = $this->getMockBuilder(AbstractRepository::class)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();

        $repositoryClass = 'My\\Path\\To\\Repository\\DummyRepository';
        $expectedEntityClass = 'My\\Path\\To\\Entity\\Dummy';

        $this->assertSame(
            $expectedEntityClass,
            $abstract->repositoryIntoEntityClassConverter($repositoryClass)
        );
    }

    /**
     * @depends testRepositoryIntoEntityClassConverter
     */
    public function testRepositoryClassWithEntity()
    {
        $abstract = new DummyRepository($this->registry(Dummy::class));

        $this->assertSame(
            Dummy::class,
            $abstract->getClassName()
        );
    }

    /**
     * @depends testRepositoryIntoEntityClassConverter
     */
    public function testRepositoryClassWithoutEntity()
    {
        $this->expectException(EntityDoesNotExistException::class);

        new class($this->registry(null)) extends AbstractRepository
        {
        };
    }

    private function registry(?string $entityClass): ManagerRegistry
    {
        $classMetadata = new ClassMetadata($entityClass);

        $manager = $this->prophesize(EntityManagerInterface::class);
        $manager->getClassMetadata($entityClass)->willReturn($classMetadata);

        $registry = $this->prophesize(ManagerRegistry::class);
        $registry->getManagerForClass($entityClass)->willReturn($manager->reveal());

        return $registry->reveal();
    }
}
