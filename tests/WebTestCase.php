<?php declare(strict_types=1);

namespace App\Tests;

use Symfony\Bundle\MakerBundle\Str;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Panther\Client;
use Symfony\Component\Panther\DomCrawler\Crawler;
use Symfony\Component\Panther\PantherTestCase;

abstract class WebTestCase extends PantherTestCase implements WebTestCaseInterface
{
    const SHORT_TIMEOUT_IN_SECOND = 3;

    const SCREENSHOT_FOLDER = 'build' . DIRECTORY_SEPARATOR . 'tests' . DIRECTORY_SEPARATOR . 'screenshots' . DIRECTORY_SEPARATOR;
    const SCREENSHOT_EXTENSION = '.png';
    const UNDERSCORE = '_';
    const LINE = 'line';
    const DOUBLE_COLON = '::';

    private $filesystem;

    /** {@inheritDoc} */
    public function __construct($name = null, array $data = [], $dataName = '')
    {
        $this->filesystem = new Filesystem();
        $this->filesystem->remove(self::SCREENSHOT_FOLDER);
        $this->filesystem->mkdir(self::SCREENSHOT_FOLDER);

        parent::__construct($name, $data, $dataName);
    }

    /** {@inheritDoc} */
    public function takeScreenshot(Client $client, Crawler $crawler): void
    {
        $debug = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
        $file = $this->getScreenshotFile($debug, $crawler);
        $client->takeScreenshot($file);
    }

    /** {@inheritDoc} */
    public function getScreenshotFile(array $debug, Crawler $crawler): string
    {
        $line = $debug[0]['line'];
        $class = $debug[1]['class'];
        $function = $debug[1]['function'];

        $count = 0;
        $uri = $crawler->getUri();
        $filename = Str::asCamelCase($class)
            . self::DOUBLE_COLON . $function
            . self::UNDERSCORE . self::LINE . $line
            . self::UNDERSCORE . self::UNDERSCORE . Str::asSnakeCase($uri);

        do {
            $underscoreCount = $count > 0 ? self::UNDERSCORE . $count : '';
            $file = self::SCREENSHOT_FOLDER . $filename . $underscoreCount . self::SCREENSHOT_EXTENSION;
            $count++;
        } while ($this->filesystem->exists($file));

        return $file;
    }
}
