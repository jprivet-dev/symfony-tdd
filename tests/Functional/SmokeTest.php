<?php

namespace App\Tests\Functional;

use App\Tests\WebTestCase;

class SmokeTest extends WebTestCase
{
    /**
     * @dataProvider urlProvider
     * @param string $route
     */
    public function testResponseIsSuccessful(string $route)
    {
        $client = self::createClient();

        $url = $client->getContainer()->get('router')->generate($route);
        $client->request('GET', $url);

        $this->assertResponseIsSuccessful();
    }

    public function urlProvider()
    {
        yield ['hello'];
        yield ['product'];
    }
}
