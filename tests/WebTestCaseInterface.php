<?php declare(strict_types=1);

namespace App\Tests;

use Symfony\Component\Panther\Client;
use Symfony\Component\Panther\DomCrawler\Crawler;

interface WebTestCaseInterface
{
    /**
     * Takes a screenshot.
     *
     * @param Client $client
     * @param Crawler $crawler
     */
    public function takeScreenshot(Client $client, Crawler $crawler): void;

    /**
     * Generate the file name from the uri of crawler.
     *
     * @param array $debug
     * @param Crawler $crawler
     * @return string
     */
    public function getScreenshotFile(array $debug, Crawler $crawler): string;
}