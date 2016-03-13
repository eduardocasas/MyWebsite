<?php

namespace AppBundle\Twig;

use Twig_Extension;
use Twig_SimpleFilter;

class TextExtension extends Twig_Extension
{
    public function getFilters()
    {
        return [new Twig_SimpleFilter('github_truncate', [$this, 'githubTruncate'])];
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
