<?php declare(strict_types=1);

namespace App\Repository;

use App\Entity\News;
use Doctrine\ORM\QueryBuilder;

class NewsRepository extends AbstractRepository implements NewsRepositoryInterface
{
    const ALIAS = 'n';
    const PUBLISHED = true;

    /**
     * {@inheritDoc}
     */
    public function findAllPublished(): array
    {
        $queryBuilder = $this->createQueryBuilder(self::ALIAS);
        self::isPublished($queryBuilder);

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * {@inheritDoc}
     */
    public function findOnePublishedBySlug(string $slug): ?News
    {
        $queryBuilder = $this->createQueryBuilder(self::ALIAS);
        self::isPublished($queryBuilder);
        self::withSlug($queryBuilder, $slug);

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }

    private static function isPublished(QueryBuilder $queryBuilder): void
    {
        $queryBuilder
            ->andWhere(self::ALIAS . '.published = :published')
            ->setParameter('published', self::PUBLISHED);
    }

    private static function withSlug(QueryBuilder $queryBuilder, string $slug): void
    {
        $queryBuilder
            ->andWhere(self::ALIAS . '.slug = :slug')
            ->setParameter('slug', $slug);
    }
}
