<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

abstract class AbstractRepository extends ServiceEntityRepository
{
    /**
     * AbstractServiceEntityRepository constructor.
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, $this->getTheEntityClassAttachedToTheRepositoryClass());
    }

    /**
     * @return string
     */
    public function getTheEntityClassAttachedToTheRepositoryClass(): string
    {
        $repositoryClass = get_class($this);

        return $this->convertRepositoryClassIntoEntityClass($repositoryClass);
    }

    /**
     * @param string $repositoryClass
     * @return string
     */
    public function convertRepositoryClassIntoEntityClass(string $repositoryClass): string
    {
        $entityClass = str_replace(
            ['\\Repository\\', 'Repository'],
            ['\\Entity\\', ''],
            $repositoryClass
        );

        return $entityClass;
    }

    /**
     * Used for functional tests
     */
    public function tearDown(): void
    {
        $this->_em->close();
        $this->_em = null; // avoid memory leaks
    }
}