<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

abstract class BaseControllerTest extends WebTestCase
{
    protected function getClient()
    {
        return static::createClient([], ['HTTP_HOST' => 'dev.eduardocasas.com']);
    }
}
