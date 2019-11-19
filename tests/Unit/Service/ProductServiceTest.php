<?php declare(strict_types=1);

namespace App\Tests\Unit\Service;

use App\Repository\ProductRepositoryInterface;
use App\Service\ProductService;
use App\Tests\Unit\TestCase;
use App\Validator\Constraints\Reference;
use Prophecy\Argument;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ProductServiceTest extends TestCase
{
    const FAKE_REFERENCE = '__FAKE_REFERENCE__';

    private $productRepository;
    private $validator;
    private $productService;

    protected function setUp(): void
    {
        $this->productRepository = $this->prophesize(ProductRepositoryInterface::class);
        $this->validator = $this->prophesize(ValidatorInterface::class);

        $this->productService = new ProductService(
            $this->productRepository->reveal(),
            $this->validator->reveal()
        );
    }

    public function testCkeckAll()
    {
        // Arrange
        $this->productRepository->findAll()->willReturn([]);

        // Act
        $this->productService->checkAll();

        // Assert
        $this->productRepository->findAll()->shouldHaveBeenCalledTimes(1);
    }

    public function testValidateReference()
    {
        // Act
        $this->productService->validateReference(self::FAKE_REFERENCE);

        // Assert
        $this->validator
            ->validate(self::FAKE_REFERENCE, Argument::type(Reference::class))
            ->shouldHaveBeenCalledTimes(1);
    }

    /**
     * @expectedDeprecation Using `App\Service\ProductService::legacyValidateReference()` method is deprecated since App version 1.0, use `App\Service\ProductService::validateReference()` instead.
     * @group legacy
     */
    public function testLegacyValidateReference()
    {
        // Act
        $this->productService->legacyValidateReference(self::FAKE_REFERENCE);
    }

    /**
     * Allows to display the legacy deprecation notice in the terminal for the demo
     */
    public function testLegacyValidateReferenceDisplayDeprecationNoticeInTerminal()
    {
        // Act
        $this->productService->legacyValidateReference(self::FAKE_REFERENCE);

        // Assert
        $this->validator
            ->validate(self::FAKE_REFERENCE, Argument::type(Reference::class))
            ->shouldHaveBeenCalledTimes(1);
    }
}
