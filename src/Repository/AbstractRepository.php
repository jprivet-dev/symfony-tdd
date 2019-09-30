<?php

namespace App\Repository;

use App\Exception\EntityDoesNotExistException;
use App\Util\ClassUtilInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

abstract class AbstractRepository extends ServiceEntityRepository implements AbstractRepositoryInterface
{
    /**
     * @var ClassUtilInterface
     */
    private $classUtil;

    public function __construct(ManagerRegistry $registry, ClassUtilInterface $classUtil)
    {
        $this->classUtil = $classUtil;
        $repositoryClass = $this->classUtil->get($this);

        parent::__construct($registry, $this->getTheEntityClassAttachedToTheRepositoryClass($repositoryClass));
    }

    /**
     * {@inheritdoc}
     */
    public function getTheEntityClassAttachedToTheRepositoryClass(string $repositoryClass): string
    {
        $entityClass = $this->convertRepositoryClassIntoEntityClass($repositoryClass);

        if (!$this->classUtil->exists($entityClass)) {
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