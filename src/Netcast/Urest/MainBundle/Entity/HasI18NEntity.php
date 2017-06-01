<?php
/**
 * Created by PhpStorm.
 * User: Patsay Sergey
 * Date: 16.05.2017
 * Time: 19:36
 */

namespace Netcast\Urest\MainBundle\Entity;


use Doctrine\Common\Collections\Criteria;

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

    /**
     * @return array
     */
    public function getContent() {
        $criteria = Criteria::create()
            ->where(Criteria::expr()->eq('lang', $this->currentLocale))
        ;
        $content = $this->{$this->contentField}->matching($criteria);

        if($content->count() > 0) return $content->first();
        $criteria->where(Criteria::expr()->eq('lang', $this->defaultLocale));
        $content = $this->{$this->contentField}->matching($criteria);
        if($content->count()) return $content->first();
    }

    public function __toString() {
        return $this->getContent() ? $this->getContent()->getTitle() : '';
    }

}