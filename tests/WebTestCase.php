<?php declare(strict_types=1);

namespace App\Tests;

use Symfony\Bundle\MakerBundle\Str;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Panther\Client;
use Symfony\Component\Panther\DomCrawler\Crawler;
use Symfony\Component\Panther\PantherTestCase;

abstract class WebTestCase extends PantherTestCase implements WebTestCaseInterface
{
    const SCREENSHOT_FOLDER = 'build' . DIRECTORY_SEPARATOR . 'screenshot' . DIRECTORY_SEPARATOR;
    const SCREENSHOT_EXTENSION = 'png';

    private $filesystem;

    /** {@inheritDoc} */
    public function __construct($name = null, array $data = [], $dataName = '')
    {
        $this->filesystem = new Filesystem();
        $this->filesystem->mkdir(self::SCREENSHOT_FOLDER);

        parent::__construct($name, $data, $dataName);
    }

    /** {@inheritDoc} */
    public function takeScreenshot(Client $client, Crawler $crawler): void
    {
        $file = $this->getScreenshotFile($crawler);
        $client->takeScreenshot($file);
    }

    /** {@inheritDoc} */
    public function getScreenshotFile(Crawler $crawler): string
    {
        $uri = $crawler->getUri();
        $filename = Str::asSnakeCase($uri);
        $file = sprintf('%s%s.%s', self::SCREENSHOT_FOLDER, $filename, self::SCREENSHOT_EXTENSION);

        return $file;
    }
}
