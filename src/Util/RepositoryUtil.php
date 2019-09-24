<?php

namespace App\Util;

class RepositoryUtil implements RepositoryUtilInterface
{
    /**
     * {@inheritdoc}
     */
    public function convertRepositoryClassIntoEntityClass(string $repositoryClass): string
    {
        $entityClass = str_replace(
            ['\\Repository\\', 'Repository'],
            ['\\Entity\\', ''],
            $repositoryClass
        );

        return $entityClass;
    }
}