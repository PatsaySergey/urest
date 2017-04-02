<?php

namespace Netcast\Urest\MainBundle\Twig;

class SmartSliceExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            'smart_slice' => new \Twig_Filter_Method($this, 'slice'),
        );
    }

    public function slice($str,$start,$end)
    {
        $str = strip_tags($str);
        mb_internal_encoding("UTF-8");

        if($end <= $start) return '';
        $smartEnd = mb_strpos(mb_substr($str,$end),' ');

        $SmartStr = mb_substr($str,$start,($end+$smartEnd+1),"UTF-8");
        $SmartStr .= (strlen($str) > strlen($SmartStr))?'...':'';
        return $SmartStr;
    }

    public function getName()
    {
        return 'smart_slice';
    }
}