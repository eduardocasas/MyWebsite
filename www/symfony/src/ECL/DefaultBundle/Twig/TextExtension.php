<?php
namespace ECL\DefaultBundle\Twig;

use Twig_Extension;
use Twig_Filter_Method;

class TextExtension extends Twig_Extension
{
    
    public function __construct() {
        $this->getLocale();
    }
    public function getFilters()
    {
        return array(
            'github_truncate'    => new Twig_Filter_Method($this, 'githubTruncate'),
            'remove_whitespaces' => new Twig_Filter_Method($this, 'removeWhitespaces'),
            'file_extension'     => new Twig_Filter_Method($this, 'getFileExtension'),
            'long_date'          => new Twig_Filter_Method($this, 'getLongDate'),
            'long_long_date'     => new Twig_Filter_Method($this, 'getLongLongDate'),
            'min_long_date'      => new Twig_Filter_Method($this, 'getMinLongDate')
        );
    }
    
    public function githubTruncate($string)
    {
        return str_replace('eduardocasas ', '', $string);
    }
    
    public function removeWhitespaces($file_name)
    {
        return str_replace(' ', '%20', $file_name);
    }

    public function getFileExtension($file_name)
    {
        return strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    }
    
    public function getLongDate($date)
    {
        return strftime('%A %e de %B del %Y', $date->getTimestamp());
    }
    
    public function getLongLongDate($date)
    {
        $format = '%A %e de %B del %Y a las %H:%M';
        if ($date) {
            return strftime($format, strtotime ($date));
        } else {
            return strftime($format);
        }
    }
    
    public function getMinLongDate($date)
    {
        return strftime('%e/%m/%y | %H:%M', strtotime($date));
    }
    
    public function getName()
    {
        return 'text_extension';
    }
    
    private function getLocale()
    {

        setlocale(LC_ALL, 'C'); // <--- necesario para evitar problemas "cache"
        //setlocale(LC_ALL, "es_ES", "es_ES.utf8", "es_ES", "es_ES.iso88591", "es_ES@euro", "es_ES.iso885915@euro");
        setlocale(LC_ALL, "es_ES");
    }
    
}
