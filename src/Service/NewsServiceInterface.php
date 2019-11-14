<?php declare(strict_types=1);

namespace App\Service;

use App\Entity\News;
use App\Repository\NewsRepositoryInterface;

interface NewsServiceInterface
{
    /**
     * NewsServiceInterface constructor.
     * @param NewsRepositoryInterface $newsRepository
     */
    public function __construct(NewsRepositoryInterface $newsRepository);

    /**
     * @return array
     */
    public function collection(): array;

    /**
     * @param string $slug
     * @return News|null
     */
    public function item(string $slug): ?News;
}
