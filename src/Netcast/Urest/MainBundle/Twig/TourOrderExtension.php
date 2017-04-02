<?php

namespace Netcast\Urest\MainBundle\Twig;

class TourOrderExtension extends \Twig_Extension
{
    private $formFactory = null;
    private $formType = null;


    public function getFunctions() {
        return [
            'order_form' => new \Twig_Function_Method($this, 'getOrderForm')
        ];
    }

    public function setFormFactory($formFactory)
    {
        $this->formFactory = $formFactory;
    }

    public function setFormType($formType)
    {
        $this->formType = $formType;
    }

    public function getOrderForm()
    {
        return $this->formFactory->create($this->formType)->createView();
    }

    public function getName()
    {
        return 'netcast.urest.twig.tour_order_form';
    }
}