<?php
/**
 * Created by PhpStorm.
 * User: Patsay Sergey
 * Date: 22.05.2017
 * Time: 21:20
 */

namespace Netcast\Urest\MainBundle\Entity;


class IsI18NEntity
{
    private $isDeleted = 0;

    /**
     * @var HasI18NEntity
     */
    protected $parent;

    /**
     * @var Language
     */
    protected $lang;

    public function setIsDeleted($isDeleted) {
        $this->isDeleted = $isDeleted;

        return $this;
    }

    public function getIsDeleted() {
        return $this->isDeleted;
    }

    /**
     * Set lang
     *
     * @param Language $lang
     * @return IsI18NEntity
     */
    public function setLang(Language $lang)
    {
        $this->lang = $lang;

        return $this;
    }

    /**
     * Get lang
     *
     * @return Language
     */
    public function getLang()
    {
        return $this->lang;
    }

    /**
     * Set parent
     *
     * @param HasI18NEntity $parent
     * @return $this
     */
    public function setParent(HasI18NEntity $parent) {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return HasI18NEntity
     */
    public function getParent() {
        return $this->parent;
    }

    public function __toString()
    {
        return (string) $this->getTitle();
    }
}