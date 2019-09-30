<?php

namespace App\Repository;

interface AbstractRepositoryInterface
{
    /**
     * @return string
     */
    function getTheEntityClassAttachedToTheRepositoryClass(string $repositoryClass): string;

    /**
     * @param string $repositoryClass
     * @return string
     */
    function convertRepositoryClassIntoEntityClass(string $repositoryClass): string;

    /**
     * @return string
     */
    function getEntityClass(): string;

    /**
     * Very practical for functional tests
     */
    function closeEntityManager(): void;
}