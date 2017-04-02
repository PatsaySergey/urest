<?php

    namespace Netcast\Urest\MainBundle\Form\Type;

    use Symfony\Component\Form\AbstractType;

    /**
     * @author Sergey
     */
    class UrestCollectionType extends AbstractType
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
            return 'urest_collection';
        }
    }
