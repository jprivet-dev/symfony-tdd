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
            $this->getTheEntityClassAttachedToTheRepositoryClass(\get_class($this))
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getTheEntityClassAttachedToTheRepositoryClass(string $repositoryClass): string
    {
        $entityClass = $this->convertRepositoryClassIntoEntityClass($repositoryClass);

        if (!\class_exists($entityClass)) {
            throw new EntityDoesNotExistException($entityClass);
        }

        return $entityClass;
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