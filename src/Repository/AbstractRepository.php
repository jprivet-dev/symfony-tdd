<?php

namespace App\Repository;

use App\Exception\EntityDoesNotExistException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

abstract class AbstractRepository extends ServiceEntityRepository implements AbstractRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct(
            $registry,
            $this->getEntityClass()
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getEntityClass(): string
    {
        $repositoryClass = \get_class($this);
        $entityClass = $this->convertRepositoryClassIntoEntityClass($repositoryClass);

        if (\class_exists($entityClass)) {
            return $entityClass;
        }

        throw new EntityDoesNotExistException($entityClass);
    }

    /**
     * {@inheritdoc}
     */
    public function convertRepositoryClassIntoEntityClass(string $repositoryClass): string
    {
        return str_replace(
            ['Repository\\', 'Repository'],
            ['Entity\\', ''],
            $repositoryClass
        );
    }
}
