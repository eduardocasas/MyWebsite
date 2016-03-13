<?php

namespace AppBundle\Tests\Controller\Contact;

use AppBundle\Tests\Controller\BaseControllerTest;

class DefaultControllerTest extends BaseControllerTest
{
    public function testIndex()
    {
        $client = $this->getClient();
        $crawler = $client->request('GET', '/en/contact');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('Eduardo Casas | Web Developer | Contact', $crawler->filter('title')->text());
        $crawler = $client->request('GET', '/es/contacto');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('Eduardo Casas | Desarrollador Web | Contacto', $crawler->filter('title')->text());
    }
}
