<?php declare(strict_types=1);

namespace App\Tests\Unit\Controller;

use App\Controller\NewsController;
use App\Entity\News;
use App\Service\NewsServiceInterface;
use App\Tests\Shared\Unit\TestCase;
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
        $this->newsController->setContainer($this->getContainer());
    }

    /**
     * @dataProvider collectionProvider
     * @param array $collection
     */
    public function testIndex(array $collection)
    {
        // Arrange
        $this->newsService->collection()->willReturn($collection);

        // Act
        $reponse = $this->newsController->index();

        // Assert
        $this->newsService->collection()->shouldHaveBeenCalledTimes(1);
        $this->assertInstanceOf(Response::class, $reponse);
    }

    /**
     * @dataProvider itemProvider
     * @param News|null $news
     */
    public function testItem(?News $news)
    {
        // Arrange
        $this->newsService->item('__SLUG__')->willReturn($news);

        // Act
        $reponse = $this->newsController->item('__SLUG__');

        // Assert
        $this->newsService->item('__SLUG__')->shouldHaveBeenCalledTimes(1);
        $this->assertInstanceOf(Response::class, $reponse);
    }

    public function collectionProvider()
    {
        $news = $this->prophesize(News::class)->reveal();

        yield [[]];
        yield [[$news]];
        yield [[$news], [$news]];
    }

    public function itemProvider()
    {
        $news = $this->prophesize(News::class)->reveal();

        yield [$news];
    }

    /**
     * The following configuration is required to use
     * vendor/symfony/framework-bundle/Controller/ControllerTrait.php::render().
     *
     * To find the correspondence between the names of the services and the used classes
     * see vendor/symfony/framework-bundle/Controller/AbstractController.php::getSubscribedServices().
     *
     * @return ContainerInterface
     */
    private function getContainer(): ContainerInterface
    {
        $container = $this->prophesize(ContainerInterface::class);
        $twig = $this->prophesize(Environment::class);

        $container->has('templating')->willReturn(false);
        $container->has('twig')->willReturn(true);
        $container->get('twig')->willReturn($twig->reveal());

        return $container->reveal();
    }
}