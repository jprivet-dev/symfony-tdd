<?php

namespace App\Repository;

use App\Exception\EntityDoesNotExistException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * This abstract class is inspired by the "Inject a repository instead of an entity manager" article by Matthias Noback.
 * It is able to find the entity (Dummy.php) attached to the injected repository (DummyRepository.php).
 * Examples of trees:
 *
 * .
 * `-- src
 *      |-- Entity
 *      |      `-- Dummy.php
 *      `-- Repository
 *             `-- DummyRepository.php
 *
 * .
 * `-- src
 *      `-- AppBundle
 *              |-- Entity
 *              |      `-- Dummy.php
 *              `-- Repository
 *                     `-- DummyRepository.php
 *
 * @see https://matthiasnoback.nl/2014/05/inject-a-repository-instead-of-an-entity-manager/
 * @see https://github.com/jprivet-dev/symfony-tdd
 */
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
