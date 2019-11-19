<?php declare(strict_types=1);

namespace App\Tests\Functional\Repository;

use App\Entity\News;
use App\Repository\NewsRepository;
use App\Tests\Functional\RepositoryWebTestCase;

class NewsRepositoryTest extends RepositoryWebTestCase
{
    const COUNT_ALL = 3;
    const COUNT_PUBLISHED = 2;

    const SLUG_WRONG = '__x_x_x__';
    const SLUG_PUBLISHED = 'symfony-live-usa-2018';
    const SLUG_NOT_PUBLISHED = 'not-published-news';

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
        $slug = self::SLUG_PUBLISHED;

        // Act
        $news = $this->repository->findOnePublishedBySlug($slug);

        // Assert
        $this->assertInstanceOf(News::class, $news);
        $this->assertSame($slug, $news->getSlug());
    }

    /**
     * @dataProvider slugProvider
     * @param string $slug
     */
    public function testFindOnePublishedReturnsNull(string $slug)
    {
        // Act
        $news = $this->repository->findOnePublishedBySlug($slug);

        // Assert
        $this->assertNull($news);
    }

    public function slugProvider()
    {
        yield 'Wrong slug' => [self::SLUG_WRONG];
        yield 'Good slug but news does not published' => [self::SLUG_NOT_PUBLISHED];
    }
}