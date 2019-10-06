<?php

namespace App\Service;

use Symfony\Component\Validator\ConstraintViolationListInterface;

interface ProductServiceInterface
{
    public function checkAll();

    /**
     * @param string $reference
     * @return null|ConstraintViolationListInterface
     */
    public function validateReference(string $reference): ?ConstraintViolationListInterface;

    /**
     * @param string $reference
     * @return null|ConstraintViolationListInterface
     */
    public function legacyValidateReference(string $reference): ?ConstraintViolationListInterface;
}
