<?php

namespace AppBundle\Tests\Controller\Blog;

use AppBundle\Tests\Controller\BaseControllerTest;

class DefaultControllerTest extends BaseControllerTest
{
    public function testIndex()
    {
        $client = $this->getClient();
        $crawler = $client->request('GET', '/en/blog');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('Eduardo Casas | Web Developer | Blog', $crawler->filter('title')->text());
        $crawler = $client->request('GET', '/es/blog');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('Eduardo Casas | Desarrollador Web | Blog', $crawler->filter('title')->text());
    }
}
