<?php

namespace App\Service;

use App\Repository\ProductRepositoryInterface;

class ProductService implements ProductServiceInterface
{
    private $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function checkAll()
    {
        $products = $this->productRepository->findAll();
    }
}