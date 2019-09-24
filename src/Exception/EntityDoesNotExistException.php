<?php

namespace App\Exception;

final class EntityDoesNotExistException extends \Exception
{
    const DEFAULT_MESSAGE = 'the entity "%s" does not exist.';

    public function __construct(string $entityClass)
    {
        parent::__construct(sprintf(self::DEFAULT_MESSAGE, $entityClass));
    }
}