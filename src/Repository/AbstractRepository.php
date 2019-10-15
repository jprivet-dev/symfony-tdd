<?php

namespace App\Repository;

use App\Exception\EntityDoesNotExistException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

abstract class AbstractRepository extends ServiceEntityRepository implements AbstractRepositoryInterface
{
    const SEARCH = ['Repository\\', 'Repository'];
    const REPLACE = ['Entity\\', ''];

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
        $repositoryClass = $this->getRepositoryClass();
        $entityClass = $this->repositoryIntoEntityClassConverter($repositoryClass);

        if (\class_exists($entityClass)) {
            return $entityClass;
        }

        throw new EntityDoesNotExistException($entityClass);
    }

    /**
     * {@inheritdoc}
     */
    public function getRepositoryClass(): string
    {
        return \get_class($this);
    }

    /**
     * {@inheritdoc}
     */
    public function repositoryIntoEntityClassConverter(string $repositoryClass): string
    {
        return str_replace(self::SEARCH, self::REPLACE, $repositoryClass);
    }
}
