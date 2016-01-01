<?php

namespace AppBundle\Tests\Controller\home;

use AppBundle\Tests\Controller\BaseControllerTest;

class DefaultControllerTest extends BaseControllerTest
{

    public function testIndex()
    {
        $client = $this->getClient();
        $crawler = $client->request('GET', '/en/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('Eduardo Casas | Web Developer', $crawler->filter('title')->text());
        $crawler = $client->request('GET', '/es/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('Eduardo Casas | Desarrollador Web', $crawler->filter('title')->text());        
    }

}
