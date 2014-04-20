<?php
namespace ECL\DefaultBundle\Service;

use phpbrowscap\Browscap;

class Browser
{

    private $Broser;
    
    public function __construct($service_container)
    {
        $this->Broser = (new Browscap($service_container->getParameter("kernel.cache_dir")))->getBrowser();
    }
    
    public function getFolder()
    {
        return ($this->isMobile()) ?  'mobile' : 'pc';
    }
    
    public function hasWebKitRenderingEngine()
    {
        return $this->getRenderingEngine() == 'WebKit';
    }
    
    private function getRenderingEngine()
    {
        return $this->Broser->RenderingEngine_Name;
    }
    
    private function isMobile()
    {
        return $this->Broser->isMobileDevice;
    }

}
