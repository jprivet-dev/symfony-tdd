<?php

namespace App\Util;

interface ClassUtilInterface
{
    /**
     * get_class alias
     *
     * @param $object
     * @return string
     */
    function get($object): string;

    /**
     * class_exists alias
     *
     * @param string $className
     * @return bool
     */
    function exists(string $className): bool;
}