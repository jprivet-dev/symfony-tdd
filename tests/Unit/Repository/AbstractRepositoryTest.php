<?php

namespace App\Tests\Unit\Repository;

use App\Exception\EntityDoesNotExistException;
use App\Repository\AbstractRepository;
use App\Tests\Shared\Models\Entity\Dummy;
use App\Tests\Shared\Models\Repository\DummyRepository;
use App\Tests\TestCase;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetadata;
use Symfony\Bridge\Doctrine\ManagerRegistry;

class AbstractRepositoryTest extends TestCase
{
    /**
     * @dataProvider classNameProvider
     * @param string $repositoryClass
     * @param string $expectedEntityClass
     */
    public function testRepositoryIntoEntityClassConverter(string $repositoryClass, string $expectedEntityClass)
    {
        $abstract = $this->getMockBuilder(AbstractRepository::class)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();

        $this->assertSame(
            $expectedEntityClass,
            $abstract->repositoryIntoEntityClassConverter($repositoryClass)
        );
    }

    public function classNameProvider()
    {
        return [
            [
                'DummyRepository',
                'Dummy',
            ],
            [
                'Repository\\DummyRepository',
                'Entity\\Dummy',
            ],
            [
                'My\\Class\\Name\\Repository\\DummyRepository',
                'My\\Class\\Name\\Entity\\Dummy',
            ]
        ];
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

        new class($this->registry()) extends AbstractRepository
        {
        };
    }

    private function registry(?string $entityClass = null): ManagerRegistry
    {
        $classMetadata = new ClassMetadata($entityClass);

        $manager = $this->prophesize(EntityManagerInterface::class);
        $manager->getClassMetadata($entityClass)->willReturn($classMetadata);

        $registry = $this->prophesize(ManagerRegistry::class);
        $registry->getManagerForClass($entityClass)->willReturn($manager->reveal());

        return $registry->reveal();
    }
}
