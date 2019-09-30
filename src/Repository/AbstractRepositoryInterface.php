<?php

namespace App\Repository;

interface AbstractRepositoryInterface
{
    /**
     * @return string
     */
    function getTheEntityClassAttachedToTheCurrentRepositoryClass(): string;

    /**
     * @return string
     */
    function getEntityClass(): string;

    /**
     * Very practical for functional tests
     */
    function closeEntityManager(): void;
}