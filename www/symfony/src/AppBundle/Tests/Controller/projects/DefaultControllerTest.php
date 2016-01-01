<?php

namespace AppBundle\Tests\Controller\projects;

use AppBundle\Tests\Controller\BaseControllerTest;

class DefaultControllerTest extends BaseControllerTest
{

    public function testIndex()
    {
        $client = $this->getClient();
        $crawler = $client->request('GET', '/en/projects');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('Eduardo Casas | Web Developer | Personal Projects', $crawler->filter('title')->text());
        $crawler = $client->request('GET', '/es/proyectos');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('Eduardo Casas | Desarrollador Web | Proyectos Personales', $crawler->filter('title')->text());        
    }

}
