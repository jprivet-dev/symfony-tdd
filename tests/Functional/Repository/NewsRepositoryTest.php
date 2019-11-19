<?php declare(strict_types=1);

namespace App\Tests\Functional\Repository;

use App\Entity\News;
use App\Repository\NewsRepository;
use App\Tests\RepositoryWebTestCase;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;

class NewsRepositoryTest extends RepositoryWebTestCase
{
    use RefreshDatabaseTrait;

    const COUNT_ALL = 3;
    const COUNT_PUBLISHED = 2;
    const SLUG = 'symfony-live-usa-2018';

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
        $slug = self::SLUG;

        // Act
        $news = $this->repository->findOnePublishedBySlug($slug);

        // Assert
        $this->assertInstanceOf(News::class, $news);
        $this->assertSame($slug, $news->getSlug());
    }

    public function testFindOnePublishedBySlugWrongSlug()
    {
        // Arrange
        $slug = '_x_x_x_';

        // Act
        $news = $this->repository->findOnePublishedBySlug($slug);

        // Assert
        $this->assertNull($news);
    }
}