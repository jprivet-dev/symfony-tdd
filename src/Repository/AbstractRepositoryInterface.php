<?php

namespace App\Repository;

interface AbstractRepositoryInterface
{
    /**
     * @return string
     */
    public function getEntityClass(): string;

    /**
     * @param string $repositoryClass
     * @return string
     */
    public function convertRepositoryClassIntoEntityClass(string $repositoryClass): string;
}
