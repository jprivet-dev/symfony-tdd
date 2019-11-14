<?php declare(strict_types=1);

namespace App\Tests\Unit\Repository;

use App\Exception\EntityDoesNotExistException;
use App\Repository\AbstractRepository;
use App\Tests\Shared\Dummy\Entity\Dummy;
use App\Tests\Shared\Dummy\Repository\DummyRepository;
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
        // Arrange
        $abstract = $this->getMockBuilder(AbstractRepository::class)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();

        // Act
        $entityClass = $abstract->repositoryIntoEntityClassConverter($repositoryClass);

        // Assert
        $this->assertSame($expectedEntityClass, $entityClass);
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
        // Arrange
        $abstract = new DummyRepository($this->registry(Dummy::class));

        // Act
        $className = $abstract->getClassName();

        // Assert
        $this->assertSame(Dummy::class, $className);
    }

    /**
     * @depends testRepositoryIntoEntityClassConverter
     */
    public function testRepositoryClassWithoutEntity()
    {
        $this->expectException(EntityDoesNotExistException::class);

        // Act
        new class($this->registry()) extends AbstractRepository
        {
        };
    }

    /**
     * @param string|null $entityClass
     * @return ManagerRegistry
     */
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
