<?php declare(strict_types=1);

namespace App\Service;

use App\Entity\News;
use App\Repository\NewsRepositoryInterface;

class NewsService implements NewsServiceInterface
{
    private $newsRepository;

    /**
     * {@inheritDoc}
     */
    public function __construct(NewsRepositoryInterface $newsRepository)
    {
        $this->newsRepository = $newsRepository;
    }

    /**
     * {@inheritDoc}
     */
    public function collection(): array
    {
        return $this->newsRepository->findAllPublished();
    }

    /**
     * {@inheritDoc}
     */
    public function item(string $slug): ?News
    {
        return $this->newsRepository->findOnePublishedBySlug($slug);
    }
}