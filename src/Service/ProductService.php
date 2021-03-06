<?php declare(strict_types=1);

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
    ) {
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
        @trigger_error(sprintf('Using `%s::legacyValidateReference()` method is deprecated since App version 1.0, use `%s::validateReference()` instead.', __CLASS__, __CLASS__), E_USER_DEPRECATED);
        $constraint = new Reference();
        return $this->validator->validate($reference, $constraint);
    }
}
