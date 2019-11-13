<?php declare(strict_types=1);

namespace App\Tests\Functional;

use App\Tests\WebTestCase;

class NewsControllerTest extends WebTestCase
{
    public function testNews()
    {
        $client = static::createPantherClient();
        $crawler = $client->request('GET', '/news');

        $this->assertCount(2, $crawler->filter('h1'));
        $this->assertSame(['week-601', 'symfony-live-usa-2018'], $crawler->filter('article')->extract('id'));

        $link = $crawler->selectLink('Join us at SymfonyLive USA 2018!')->link();
        $crawler = $client->click($link);

        $this->assertSame('Join us at SymfonyLive USA 2018!', $crawler->filter('h1')->text());
    }

    public function testComments()
    {
        $client = static::createPantherClient();
        $crawler = $client->request('GET', '/news/symfony-live-usa-2018');

        $client->waitFor('#post-comment'); // Wait for the form to appear, it may take some time because it's done in JS
        $form = $crawler->filter('#post-comment')->form(['new-comment' => 'Symfony is so cool!']);
        $client->submit($form);

        $client->waitFor('#comments ol'); // Wait for the comments to appear

        $this->assertSame(self::$baseUri.'/news/symfony-live-usa-2018', $client->getCurrentURL()); // Assert we're still on the same page
        $this->assertSame('Symfony is so cool!', $crawler->filter('#comments ol li:first-child')->text());
    }
}
