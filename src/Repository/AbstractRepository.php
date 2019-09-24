<?php

namespace App\Repository;

use App\Util\RepositoryUtilInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

abstract class AbstractRepository extends ServiceEntityRepository
{
    private $repositoryUtil;

    /**
     * AbstractServiceEntityRepository constructor.
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry, RepositoryUtilInterface $repositoryUtil)
    {
        $this->repositoryUtil = $repositoryUtil;

        $entityClass = $this->getTheEntityClassAttachedToTheCurrentRepositoryClass();
        parent::__construct($registry, $entityClass);
    }

    /**
     * @return string
     */
    public function getTheEntityClassAttachedToTheCurrentRepositoryClass(): string
    {
        $repositoryClass = get_class($this);

        return $this->repositoryUtil->convertRepositoryClassIntoEntityClass($repositoryClass);
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