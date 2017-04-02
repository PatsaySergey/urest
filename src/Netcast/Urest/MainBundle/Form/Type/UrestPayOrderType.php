<?php

namespace Netcast\Urest\MainBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * @author Sergey
 */
class UrestPayOrderType extends AbstractType
{

    /**
     * {@inheritDoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['payOrderOptions'] = $options['payOrderOptions'];
    }

    /**
     * {@inheritDoc}
     * For Symfony 2.1 and higher
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'payOrderOptions' => null
        ));
    }


    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'urest_pay_order_type';
    }
}
