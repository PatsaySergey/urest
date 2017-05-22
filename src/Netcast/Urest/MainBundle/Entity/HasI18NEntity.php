<?php
/**
 * Created by PhpStorm.
 * User: Patsay Sergey
 * Date: 16.05.2017
 * Time: 19:36
 */

namespace Netcast\Urest\MainBundle\Entity;


class HasI18NEntity
{
    protected $currentLocale;

    protected $defaultLocale;

    public function setCurrentLocale(Language $locale)
    {
        $this->currentLocale = $locale;
    }

    public function setDefaultLocale(Language $locale)
    {
        $this->defaultLocale = $locale;
    }

}