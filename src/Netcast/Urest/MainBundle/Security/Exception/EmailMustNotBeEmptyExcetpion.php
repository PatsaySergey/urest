<?php

namespace Netcast\Urest\MainBundle\Security\Exception;

class EmailMustNotBeEmptyExcetpion extends LoginzaExcetpion
{
    /**
     * {@inheritdoc}
     */
    public function getMessageKey()
    {
        return 'Вы должны разрешить получить email адрес';
    }
}