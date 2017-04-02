<?php

    namespace Netcast\Urest\MainBundle\Form\Type;

    use Symfony\Component\Form\AbstractType;
    use Symfony\Component\Form\FormBuilderInterface;

    use Symfony\Component\Form\FormEvent;
    use Symfony\Component\Form\FormEvents;
    use Sonata\MediaBundle\Form\DataTransformer\ProviderDataTransformer;

    /**
     * @author Sergey
     */
    class LabelTextType extends AbstractType
    {
        /**
         * {@inheritDoc}
         */
        public function getParent()
        {
            return 'text';
        }

        /**
         * {@inheritDoc}
         */
        public function getName()
        {
            return 'label_text';
        }
    }
