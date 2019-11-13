<?php declare(strict_types=1);

namespace App\Service;

use App\Repository\NewsRepositoryInterface;

class NewsService implements NewsServiceInterface
{
    private $newsRepository;

    public function __construct(NewsRepositoryInterface $newsRepository)
    {
        $this->newsRepository = $newsRepository;
    }
}