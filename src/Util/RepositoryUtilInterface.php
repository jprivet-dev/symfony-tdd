<?php

namespace App\Util;

interface RepositoryUtilInterface
{
    /**
     * @param string $repositoryClass
     * @return string
     */
    function convertRepositoryClassIntoEntityClass(string $repositoryClass): string;
}