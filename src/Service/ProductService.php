<?php

namespace App\Service;

use App\Repository\ProductRepositoryInterface;
use App\Validator\Constraints\Reference;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ProductService implements ProductServiceInterface
{
    private $productRepository;
    private $validator;

    public function __construct(
        ProductRepositoryInterface $productRepository,
        ValidatorInterface $validator
    )
    {
        $this->productRepository = $productRepository;
        $this->validator = $validator;
    }

    public function checkAll()
    {
        $products = $this->productRepository->findAll();
    }

    public function validateReference(string $reference): ?ConstraintViolationListInterface
    {
        $constraint = new Reference();
        return $this->validator->validate($reference, $constraint);
    }

    public function legacyValidateReference(string $reference): ?ConstraintViolationListInterface
    {
        @trigger_error(sprintf('Using the "%s::legacyValidateReference" method is deprecated since App version 1.0, use "validateReference" instead.', __CLASS__), E_USER_DEPRECATED);
        $constraint = new Reference();
        return $this->validator->validate($reference, $constraint);
    }
}
