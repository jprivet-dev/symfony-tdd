<?php declare(strict_types=1);

namespace App\Tests\Functional\Controller;

use App\Tests\Functional\ControllerWebTestCase;

class NewsControllerTest extends ControllerWebTestCase
{
    const NEWS_URL = '/news';
    const NEWS_WEEK_601_SLUG = 'week-601';
    const NEWS_SYMFONY_LIVE_SLUG = 'symfony-live-usa-2018';
    const NEWS_SYMFONY_LIVE_URL = self::NEWS_URL . '/' . self::NEWS_SYMFONY_LIVE_SLUG;
    const NEWS_SYMFONY_LIVE_TITLE = 'Join us at SymfonyLive USA 2018!';
    const NEWS_COUNT = 2;
    const NEWS_TITLE_SELECTOR = 'h1';

    const COMMENTS_LIST_SELECTOR = '#comments-list';
    const COMMENTS_LIST_FIRST_CHILD_SELECTOR = '#comments-list li:first-child';
    const NEW_COMMENT_FORM_SELECTOR = '#new-comment-form';
    const NEW_COMMENT_TEXTAREA_NAME = 'new-comment';
    const NEW_COMMENT_TITLE = 'Symfony is so cool!';

    public function testNews()
    {
        // Arrange
        $client = static::createPantherClient();

        // Act
        $crawler = $client->request('GET', self::NEWS_URL);

        // Assert
        $this->assertCount(self::NEWS_COUNT, $crawler->filter(self::NEWS_TITLE_SELECTOR));
        $this->assertSame([self::NEWS_WEEK_601_SLUG, self::NEWS_SYMFONY_LIVE_SLUG], $crawler->filter('article')->extract('id'));
        $this->takeScreenshot($client, $crawler);

        // Arrange
        $link = $crawler->selectLink(self::NEWS_SYMFONY_LIVE_TITLE)->link();

        // Act
        $crawler = $client->click($link);

        // Assert
        $this->assertSame(self::NEWS_SYMFONY_LIVE_TITLE, $crawler->filter(self::NEWS_TITLE_SELECTOR)->text());
        $this->takeScreenshot($client, $crawler);
    }

    public function testComments()
    {
        // Arrange
        $client = static::createPantherClient();

        // Act
        $crawler = $client->request('GET', self::NEWS_SYMFONY_LIVE_URL);
        $client->waitFor(self::NEW_COMMENT_FORM_SELECTOR, self::SHORT_TIMEOUT_IN_SECOND); // Wait for the form to appear, it may take some time because it's done in JS
        $this->takeScreenshot($client, $crawler);

        $form = $crawler->filter(self::NEW_COMMENT_FORM_SELECTOR)->form([self::NEW_COMMENT_TEXTAREA_NAME => self::NEW_COMMENT_TITLE]);
        $client->submit($form);
        $client->waitFor(self::COMMENTS_LIST_SELECTOR, self::SHORT_TIMEOUT_IN_SECOND); // Wait for the comments to appear

        // Assert
        $this->assertSame(self::$baseUri . self::NEWS_SYMFONY_LIVE_URL, $client->getCurrentURL()); // Assert we're still on the same page
        $this->assertSame(self::NEW_COMMENT_TITLE, $crawler->filter(self::COMMENTS_LIST_FIRST_CHILD_SELECTOR)->text());
        $this->takeScreenshot($client, $crawler);
    }
}
