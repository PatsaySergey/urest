<?php
/**
 * Created by PhpStorm.
 * User: Patsay Sergey
 * Date: 09.05.2017
 * Time: 11:04
 */

namespace Netcast\Urest\MainBundle\Form\Type;

use Symfony\Component\Form\AbstractType;

class I18nCollectionType extends AbstractType
{
    /**
     * {@inheritDoc}
     */
    public function getParent()
    {
        return 'collection';
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'urest_i18n_collection';
    }
}