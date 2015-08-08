<?php
namespace ECL\DefaultBundle\Service;

class Browser
{

    
    public function __construct($service_container)
    {
    }
    
    public function getFolder()
    {
        return 'pc';
    }
    
    public function hasWebKitRenderingEngine()
    {
        return true;
    }
    
}
