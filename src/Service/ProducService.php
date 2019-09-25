<?php

namespace App\Service;

use App\Repository\ProductRepositoryInterface;

class ProducService implements ProducServiceInterface
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