<?php

namespace AppBundle\Tests\Controller;

class SitemapControllerTest extends BaseControllerTest
{
    public function testIndex()
    {
        $client = $this->getClient();
        $crawler = $client->request('GET', '/en/sitemap.xml');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('/en/', substr($crawler->children()->first()->text(), -4));
        $this->assertContains('/en/curriculum-vitae', $crawler->children()->eq(1)->text());
        $this->assertContains('/en/projects', $crawler->children()->eq(2)->text());
        $this->assertContains('/en/contact', $crawler->children()->eq(3)->text());
        $this->assertContains('/en/blog', $crawler->children()->eq(4)->text());
        $crawler = $client->request('GET', '/es/sitemap.xml');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('/es/', substr($crawler->children()->first()->text(), -4));
        $this->assertContains('/es/curriculum-vitae', $crawler->children()->eq(1)->text());
        $this->assertContains('/es/proyectos', $crawler->children()->eq(2)->text());
        $this->assertContains('/es/contacto', $crawler->children()->eq(3)->text());
        $this->assertContains('/es/blog', $crawler->children()->eq(4)->text());
    }
}
