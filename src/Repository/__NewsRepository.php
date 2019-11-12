<?php

namespace App\Repository;

class __NewsRepository
{
    private const NEWS = [
        'week-601' => [
            'slug' => 'week-601',
            'title' => 'A week of symfony #601 (2-8 July 2018)',
            'body' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore.',
        ],
        'symfony-live-usa-2018' => [
            'slug' => 'symfony-live-usa-2018',
            'title' => 'Join us at SymfonyLive USA 2018!',
            'body' => 'Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur.'
        ],
    ];

    public function findAll(): iterable
    {
        return array_values(self::NEWS);
    }

    public function findOneBySlug(string $slug): ?array
    {
        return self::NEWS[$slug] ?? null;
    }
}