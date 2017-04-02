<?php

namespace Netcast\Urest\MainBundle\Form\Type;

use Symfony\Component\Form\AbstractType;

/**
 * @author Sergey
 */
class UrestUserMediaType extends AbstractType
{
    /**
     * {@inheritDoc}
     */
    public function getParent()
    {
        return 'sonata_media_type';
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'urest_user_media_type';
    }
}
