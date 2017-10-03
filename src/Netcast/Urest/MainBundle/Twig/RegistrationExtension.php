<?php

namespace Netcast\Urest\MainBundle\Twig;

use Symfony\Component\Form\FormFactory;

class RegistrationExtension extends \Twig_Extension
{
    /**
     * @var FormFactory
     */
    private $formFactory = null;

    private $formType    = null;

    public function getFunctions()
    {
        return array(
            'reg_form' => new \Twig_Function_Method($this, 'getRegForm')
        );
    }

    public function setFormFactory($formFactory)
    {
        $this->formFactory = $formFactory;
    }

    public function setFormType($formType)
    {
        $this->formType = $formType;
    }

    public function getRegForm()
    {
        return $this->formFactory->create($this->formType)->createView();
    }

    public function getName()
    {
        return 'netcast.urest.twig.reg_form';
    }
}