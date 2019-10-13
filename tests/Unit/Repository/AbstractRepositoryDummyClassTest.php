<?php

namespace App\Tests\Unit\Repository;

use App\Exception\EntityDoesNotExistException;
use App\Tests\Shared\Models\Entity\Dummy;
use App\Tests\Shared\Models\Repository\DummyRepository;
use App\Tests\Shared\Models\Repository\DummyWithoutEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetadata;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class AbstractRepositoryDummyClassTest extends TestCase
{
    public function testRepositoryClassWithEntity()
    {
        $abstractRepository = $this->getAbstracRepositoryWithRealRepositoryClassWithEntity();
        $this->assertSame(Dummy::class, $abstractRepository->getClassName());
    }

    public function testConvertRepositoryClassIntoEntityClass()
    {
        $abstractRepository = $this->getAbstracRepositoryWithRealRepositoryClassWithEntity();

        $repositoryClass = 'My\\Path\\To\\Repository\\DummyRepository';
        $expectedEntityClass = 'My\\Path\\To\\Entity\\Dummy';

        $entityClass = $abstractRepository->convertRepositoryClassIntoEntityClass($repositoryClass);

        $this->assertSame($expectedEntityClass, $entityClass);
    }

    public function testRepositoryClassWithoutEntity()
    {
        $this->expectException(EntityDoesNotExistException::class);
        $this->getAbstracRepositoryWithRealRepositoryClassWithoutEntity();
    }

    /*
     * PRIVATE
     */

    private function getAbstracRepositoryWithRealRepositoryClassWithEntity()
    {
        $registry = $this->prophesizeRegistry(Dummy::class);
        return new DummyRepository($registry->reveal());
    }

    private function getAbstracRepositoryWithRealRepositoryClassWithoutEntity()
    {
        $registry = $this->prophesizeRegistry(null);
        return new DummyWithoutEntityRepository($registry->reveal());
    }

    private function prophesizeRegistry(?string $entityClass)
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
}
