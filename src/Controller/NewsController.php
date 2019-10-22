<?php

namespace App\Controller;

use App\Repository\NewsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NewsController extends AbstractController
{
    private $newsRepository;

    public function __construct(NewsRepository $newsRepository)
    {
        $this->newsRepository = $newsRepository;
    }

    /**
     * @Route("/", name="news_index")
     */
    public function index(): Response
    {
        return $this->render('news/news-index.html.twig', [
            'collection' => $this->newsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/news/{slug}", name="news_item")
     */
    public function item(string $slug): Response
    {
        if (null === $news = $this->newsRepository->findOneBySlug($slug)) {
            throw $this->createNotFoundException();
        }

        return $this->render('news/news-item.html.twig', ['item' => $news]);
    }
}
