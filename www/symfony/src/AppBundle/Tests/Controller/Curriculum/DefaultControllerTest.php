<?php

namespace AppBundle\Tests\Controller\Curriculum;

use AppBundle\Tests\Controller\BaseControllerTest;

class DefaultControllerTest extends BaseControllerTest
{
    public function testIndex()
    {
        $client = $this->getClient();
        $crawler = $client->request('GET', '/en/curriculum-vitae');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('Eduardo Casas | Web Developer | Curriculum Vitae', $crawler->filter('title')->text());
        $crawler = $client->request('GET', '/es/curriculum-vitae');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('Eduardo Casas | Desarrollador Web | Curriculum Vitae', $crawler->filter('title')->text());
    }
}
