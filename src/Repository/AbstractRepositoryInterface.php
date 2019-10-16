<?php

namespace App\Repository;

interface AbstractRepositoryInterface
{
    /**
     * Returns the entity attached to the current repository.
     *
     * @return string
     */
    public function getEntityClass(): string;

    /**
     * Returns the name of the current repository class.
     *
     * @return string
     */
    public function getRepositoryClass(): string;

    /**
     * Converts the name of a repository class into a name of entity class.
     *
     * @param string $repositoryClass
     * @return string
     */
    public function repositoryIntoEntityClassConverter(string $repositoryClass): string;
}
