<?php

namespace App\Tests\Functional;

use App\Params\ParamsRoutes;
use App\Tests\WebTestCase;

class SmokeTest extends WebTestCase
{
    /**
     * @dataProvider routeProvider
     * @param string $route
     */
    public function testPageIsSuccessful(string $route)
    {
        $client = self::createClient();

        /*
         * This method does not follow the following principles
         * https://symfony.com/doc/current/best_practices.html#hardcode-urls-in-a-functional-test
         * In our context, we have no constraints on public URLs.
         */
        $url = $client->getContainer()->get('router')->generate($route);
        $client->request('GET', $url);

        $this->assertResponseIsSuccessful();
    }

    public function routeProvider()
    {
        yield [ParamsRoutes::HELLO];
        yield [ParamsRoutes::PRODUCT];
    }
}
