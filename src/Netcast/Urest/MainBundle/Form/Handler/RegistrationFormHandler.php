<?php

namespace Netcast\Urest\MainBundle\Form\Handler;

use FOS\UserBundle\Form\Handler\RegistrationFormHandler as FormHandler;
use FOS\UserBundle\Model\UserInterface;

class RegistrationFormHandler extends FormHandler
{
    protected $errors = array();

    public function process($confirmation = false)
    {
        $result = array();
        $user   = $this->createUser();
        $this->form->setData($user);
        if ('POST' === $this->request->getMethod()) {
            $this->form->bind($this->request);
            if ($this->form->isValid()) {
                $this->onSuccess($user, $confirmation);
                $result['status'] = true;
                $result['errors'] = array();
            } else {
                $result['status'] = false;
                $result['errors'] = $this->getAllErrors($this->form);
            }
        }
        return $result;
    }

    public function getAllErrors($formElement)
    {
        $formName = $this->form->getName();
        $currKey  = ($formElement->getName() == $formName) ? $formName : $formName . '_' . $formElement->getName();

        foreach ($formElement->getErrors() as $key => $error) {
            $this->errors[$currKey][$key] = $error->getMessage();
        }

        foreach ($formElement->all() as $child) {
            if (!$child->isValid()) {
                foreach ($child->getErrors() as $key => $error) {
                    $this->errors[$currKey.'_'.$child->getName()][$key] = $error->getMessage();
                }
            }
            if (count($child->all())) {
                $this->getAllErrors($child);
            }
        }
        return $this->errors;
    }

    public function reMail(UserInterface $user)
    {
        $user->setEnabled(false);
        $user->setConfirmationToken($this->tokenGenerator->generateToken());
        $this->mailer->sendConfirmationEmailMessage($user);
        $this->userManager->updateUser($user);

        return true;
    }
}