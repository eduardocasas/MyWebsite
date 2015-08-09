<?php
namespace ECL\DefaultBundle\Twig;

use Twig_Extension;
use Twig_Filter_Method;

class TextExtension extends Twig_Extension
{
    
    public function getFilters()
    {
        return ['github_truncate' => new Twig_Filter_Method($this, 'githubTruncate')];
    }
    
    public function githubTruncate($string)
    {
        return str_replace('eduardocasas ', '', $string);
    }
    
    public function getName()
    {
        return 'text_extension';
    }
    
}
