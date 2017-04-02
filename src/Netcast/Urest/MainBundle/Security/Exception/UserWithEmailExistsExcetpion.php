<?php

namespace Netcast\Urest\MainBundle\Security\Exception;

class UserWithEmailExistsExcetpion extends LoginzaExcetpion
{
    /**
     * {@inheritdoc}
     */
    public function getMessageKey()
    {
        return 'Пользователь с таким email адресом уже существует';
    }
}