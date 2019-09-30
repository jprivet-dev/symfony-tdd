<?php

namespace App\Repository;

use App\Exception\EntityDoesNotExistException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

abstract class AbstractRepository extends ServiceEntityRepository implements AbstractRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        $repositoryClass = get_class($this);
        parent::__construct($registry, $this->getTheEntityClassAttachedToTheRepositoryClass($repositoryClass));
    }

    /**
     * {@inheritdoc}
     */
    public function getTheEntityClassAttachedToTheRepositoryClass(string $repositoryClass): string
    {
        $entityClass = $this->convertRepositoryClassIntoEntityClass($repositoryClass);

        if (!class_exists($entityClass)) {
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
            ['\\Repository\\', 'Repository'],
            ['\\Entity\\', ''],
            $repositoryClass
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getEntityClass(): string
    {
        return $this->_entityName;
    }

    /**
     * {@inheritdoc}
     */
    public function closeEntityManager(): void
    {
        if ($this->_em) {
            $this->_em->close();
            $this->_em = null; // avoid memory leaks
        }
    }
}