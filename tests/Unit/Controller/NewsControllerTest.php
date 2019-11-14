<?php declare(strict_types=1);

namespace App\Tests\Unit\Controller;

use App\Controller\NewsController;
use App\Entity\News;
use App\Service\NewsServiceInterface;
use App\Tests\TestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class NewsControllerTest extends TestCase
{
    private $newsService;
    private $newsController;

    protected function setUp(): void
    {
        $this->newsService = $this->prophesize(NewsServiceInterface::class);
        $this->newsController = new NewsController($this->newsService->reveal());
        $this->initContainer($this->newsController);
    }

    public function testIndex()
    {
        $this->newsService->collection()->willReturn([]);
        $reponse = $this->newsController->index();

        $this->newsService->collection()->shouldHaveBeenCalledTimes(1);
        $this->assertInstanceOf(Response::class, $reponse);
    }

    public function testItem()
    {
        $news = $this->prophesize(News::class);
        $this->newsService->item('__SLUG__')->willReturn($news);

        $reponse = $this->newsController->item('__SLUG__');

        $this->newsService->item('__SLUG__')->shouldHaveBeenCalledTimes(1);
        $this->assertInstanceOf(Response::class, $reponse);
    }

    /**
     * The following configuration is required to use
     * vendor/symfony/framework-bundle/Controller/ControllerTrait.php::render().
     *
     * To find the correspondence between the names of the services and the used classes
     * see vendor/symfony/framework-bundle/Controller/AbstractController.php::getSubscribedServices().
     *
     * @param NewsController $newsController
     */
    private function initContainer(NewsController $newsController)
    {
        $container = $this->prophesize(ContainerInterface::class);
        $twig = $this->prophesize(Environment::class);

        $container->has('templating')->willReturn(false);
        $container->has('twig')->willReturn(true);
        $container->get('twig')->willReturn($twig->reveal());

        $newsController->setContainer($container->reveal());
    }
}