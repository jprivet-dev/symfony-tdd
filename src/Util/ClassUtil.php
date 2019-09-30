<?php

namespace App\Util;

class ClassUtil implements ClassUtilInterface
{
    /**
     * {@inheritdoc}
     */
    public function get($object): string
    {
        return \get_class($object);
    }

    /**
     * {@inheritdoc}
     */
    public function exists(string $className): bool
    {
        return \class_exists($className);
    }
}