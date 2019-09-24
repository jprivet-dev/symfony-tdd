<?php

namespace App\Repository;

use App\Util\RepositoryUtilInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

abstract class AbstractRepository extends ServiceEntityRepository
{
    private $repositoryUtil;

    /**
     * AbstractRepository constructor.
     * @param ManagerRegistry $registry
     * @param RepositoryUtilInterface $repositoryUtil
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
        $entityClass = $this->repositoryUtil->convertRepositoryClassIntoEntityClass($repositoryClass);

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