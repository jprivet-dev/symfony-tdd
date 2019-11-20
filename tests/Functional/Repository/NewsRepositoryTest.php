<?php declare(strict_types=1);

namespace App\Tests\Functional\Repository;

use App\Entity\News;
use App\Repository\NewsRepository;
use App\Tests\Shared\Functional\RepositoryWebTestCase;

class NewsRepositoryTest extends RepositoryWebTestCase
{
    const COUNT_ALL = 3;
    const COUNT_PUBLISHED = 2;
    const WRONG_SLUG = '__x_x_x__';

    protected function getRepositoryClass()
    {
        return NewsRepository::class;
    }

    public function testFindAll()
    {
        // Act
        $news = $this->repository->findAll();

        // Assert
        $this->assertCount(self::COUNT_ALL, $news);
    }

    public function testFindAllPublished()
    {
        // Act
        $news = $this->repository->findAllPublished();

        // Assert
        $this->assertCount(self::COUNT_PUBLISHED, $news);
    }

    public function testFindOnePublishedBySlug()
    {
        // Arrange
        $news = $this->fixtures()->news('news_published_1');
        $slug = $news->getSlug();

        // Act
        $news = $this->repository->findOnePublishedBySlug($slug);

        // Assert
        $this->assertInstanceOf(News::class, $news);
        $this->assertSame($slug, $news->getSlug());
    }

    public function testFindOnePublishedWithWrongSlugReturnsNull()
    {
        // Arrange
        $slug = self::WRONG_SLUG;

        // Act
        $news = $this->repository->findOnePublishedBySlug($slug);

        // Assert
        $this->assertNull($news);
    }

    public function testFindOnePublishedWithNotPublishedNewsReturnsNull()
    {
        // Arrange
        $news = $this->fixtures()->news('news_not_published_1');
        $slug = $news->getSlug();

        // Act
        $news = $this->repository->findOnePublishedBySlug($slug);

        // Assert
        $this->assertNull($news);
    }
}