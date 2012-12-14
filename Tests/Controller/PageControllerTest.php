<?php

namespace Dpn\CmsBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PageControllerTest extends WebTestCase
{
    public function testPageNotFound()
    {
        $client = static::createClient();
        $client->request('GET', '/pages/not-existing');

        $this->assertTrue($client->getResponse()->isNotFound());
    }

    public function testHomepage()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/pages/home');

        $this->assertCount(1, $crawler->filter('h1:contains("Home")'));
        $this->assertCount(1, $crawler->filter('h2:contains("Home")'));
        $this->assertCount(2, $crawler->filter('p'));
    }

    public function testCaching()
    {
        $client = static::createClient();

        $client->request('GET', '/pages/home');

        /** @var $response \Symfony\Component\HttpFoundation\Response */
        $response = $client->getResponse();

        $this->assertTrue($response->headers->contains('cache-control', 'no-cache'));

        $client->request('GET', '/pages/about');

        /** @var $response \Symfony\Component\HttpFoundation\Response */
        $response = $client->getResponse();

        $this->assertTrue($response->headers->contains('cache-control', 'public, s-maxage=86400'));
    }

    public function testNavigation()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/pages/about');

        $this->assertCount(1, $crawler->filter('ul'));
        $this->assertCount(3, $crawler->filter('nav.main ul li'));

        $crawler = $client->request('GET', '/pages/foobar');

        $this->assertCount(2, $crawler->filter('ul'));
        $this->assertCount(2, $crawler->filter('nav.sub ul li'));
    }
}