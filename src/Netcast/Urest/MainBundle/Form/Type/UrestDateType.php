<?php

namespace Netcast\Urest\MainBundle\Form\Type;

use Symfony\Component\Form\AbstractType;

/**
 * @author Sergey
 */
class UrestDateType extends AbstractType
{
    /**
     * {@inheritDoc}
     */
    public function getParent()
    {
        return 'sonata_type_date_picker';
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'urest_type_date_picker';
    }
}
