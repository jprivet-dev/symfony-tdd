<?php

namespace App\Repository;

use App\Exception\EntityDoesNotExistException;
use App\Util\RepositoryUtilInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

abstract class AbstractRepository extends ServiceEntityRepository implements AbstractRepositoryInterface
{
    private $repositoryUtil;

    /**
     * {@inheritdoc}
     */
    public function __construct(ManagerRegistry $registry, RepositoryUtilInterface $repositoryUtil)
    {
        $this->repositoryUtil = $repositoryUtil;
        parent::__construct($registry, $this->getTheEntityClassAttachedToTheCurrentRepositoryClass());
    }

    /**
     * {@inheritdoc}
     */
    public function getTheEntityClassAttachedToTheCurrentRepositoryClass(): string
    {
        $repositoryClass = get_class($this);
        $entityClass = $this->repositoryUtil->convertRepositoryClassIntoEntityClass($repositoryClass);

        if (class_exists($entityClass)) {
            return $entityClass;
        }

        throw new EntityDoesNotExistException($entityClass);
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