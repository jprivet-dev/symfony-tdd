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
     * Used for functional tests
     */
    function tearDown(): void;
}