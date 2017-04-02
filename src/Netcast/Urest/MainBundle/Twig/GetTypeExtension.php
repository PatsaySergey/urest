<?php

    namespace Netcast\Urest\MainBundle\Twig;

    class GetTypeExtension extends \Twig_Extension
    {
        public function getFilters()
        {
            return array(
                'getType' => new \Twig_Filter_Method($this, 'getType'),
            );
        }

        public function getType($var)
        {
            return (gettype($var) != 'object')?gettype($var):get_class($var);
        }

        public function getName()
        {
            return 'get_type';
        }
    }