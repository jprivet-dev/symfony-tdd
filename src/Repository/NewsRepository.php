<?php declare(strict_types=1);

namespace App\Repository;

use App\Entity\News;

class NewsRepository extends AbstractRepository implements NewsRepositoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function findOnePublishedBySlug(string $slug): ?News
    {
        return $this->createQueryBuilder('n')
            ->where('n.slug = :slug')
            ->andWhere('n.published = :published')
            ->setParameter('slug', $slug)
            ->setParameter('published', true)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
