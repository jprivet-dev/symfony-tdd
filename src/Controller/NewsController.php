<?php declare(strict_types=1);

namespace App\Controller;

use App\Service\NewsServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/news")
 */
class NewsController extends AbstractController
{
    private $newsService;

    public function __construct(NewsServiceInterface $newsService)
    {
        $this->newsService = $newsService;
    }

    /**
     * @Route("/", name="news_index")
     * @return Response
     */
    public function index(): Response
    {
        return $this->render('news/news-index.html.twig', [
            'collection' => $this->newsService->collection(),
        ]);
    }

    /**
     * @Route("/{slug}", name="news_item")
     * @param string $slug
     * @return Response
     */
    public function item(string $slug): Response
    {
        return $this->render('news/news-item.html.twig', [
            'item' => $this->newsService->item($slug)
        ]);
    }
}
