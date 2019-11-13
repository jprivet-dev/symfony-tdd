<?php declare(strict_types=1);

namespace App\Service;

use App\Repository\NewsRepositoryInterface;

interface NewsServiceInterface
{
    /**
     * NewsServiceInterface constructor.
     * @param NewsRepositoryInterface $newsRepository
     */
    public function __construct(NewsRepositoryInterface $newsRepository);
}
