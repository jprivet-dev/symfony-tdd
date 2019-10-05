<?php

namespace App\Tests\Unit\Service;

use App\Repository\ProductRepositoryInterface;
use App\Service\ProductService;
use App\Validator\Constraints\Reference;
use Prophecy\Argument;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ProductServiceTest extends TestCase
{
    private $productRepository;
    private $validator;
    private $productService;

    protected function setUp()
    {
        $this->productRepository = $this->prophesize(ProductRepositoryInterface::class);
        $this->validator = $this->prophesize(ValidatorInterface::class);

        $this->productService = new ProductService(
            $this->productRepository->reveal(),
            $this->validator->reveal()
        );
    }

    public function testValidateReference()
    {
        $fakeReference = '__FAKE_REFERENCE__';

        $this->validator
            ->validate($fakeReference, Argument::type(Reference::class))
            ->shouldBeCalledTimes(1);

        $this->productService->validateReference($fakeReference);
    }
}