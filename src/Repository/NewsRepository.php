<?php declare(strict_types=1);

namespace App\Repository;

use App\Entity\News;

class NewsRepository extends AbstractRepository implements NewsRepositoryInterface
{
    const PUBLISHED = true;

    /**
     * {@inheritDoc}
     */
    public function findAllPublished(): array
    {
        return $this->createQueryBuilder('n')
            ->where('n.published = :published')
            ->setParameter('published', self::PUBLISHED)
            ->getQuery()
            ->getResult();
    }

    /**
     * {@inheritDoc}
     */
    public function findOnePublishedBySlug(string $slug): ?News
    {
        return $this->createQueryBuilder('n')
            ->where('n.slug = :slug')
            ->andWhere('n.published = :published')
            ->setParameter('slug', $slug)
            ->setParameter('published', self::PUBLISHED)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
