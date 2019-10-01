<?php

namespace App\Repository;

interface AbstractRepositoryInterface
{
    /**
     * @return string
     */
    function getEntityClass(): string;

    /**
     * @param string $repositoryClass
     * @return string
     */
    function convertRepositoryClassIntoEntityClass(string $repositoryClass): string;
}
