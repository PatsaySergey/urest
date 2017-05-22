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

    public function setIsDeleted($isDeleted) {
        $this->isDeleted = $isDeleted;

        return $this;
    }

    public function getIsDeleted() {
        return $this->isDeleted;
    }

}