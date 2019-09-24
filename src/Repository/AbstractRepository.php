<?php

namespace App\Repository;

use App\Util\RepositoryUtilInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

abstract class AbstractRepository extends ServiceEntityRepository implements AbstractRepositoryInterface
{
    private $repositoryUtil;
    private $entityClass;

    /**
     * {@inheritdoc}
     */
    public function __construct(ManagerRegistry $registry, RepositoryUtilInterface $repositoryUtil)
    {
        $this->repositoryUtil = $repositoryUtil;
        $this->entityClass = $this->getTheEntityClassAttachedToTheCurrentRepositoryClass();

        parent::__construct($registry, $this->entityClass);
    }

    /**
     * {@inheritdoc}
     */
    public function getTheEntityClassAttachedToTheCurrentRepositoryClass(): string
    {
        $repositoryClass = get_class($this);
        $entityClass = $this->repositoryUtil->convertRepositoryClassIntoEntityClass($repositoryClass);

        return $entityClass;
    }

    /**
     * {@inheritdoc}
     */
    public function getEntityClass(): string
    {
        return $this->entityClass;
    }

    /**
     * {@inheritdoc}
     */
    public function tearDown(): void
    {
        $this->_em->close();
        $this->_em = null; // avoid memory leaks
    }
}