<?php

    namespace Netcast\Urest\MainBundle\Admin;

    use Netcast\Urest\MainBundle\Admin\BasicAdmin as Admin;
    use Knp\Menu\ItemInterface as MenuItemInterface;
    use Sonata\AdminBundle\Route\RouteCollection;

    class TourCityAdmin extends Admin {

        protected function configureRoutes(RouteCollection $collection)
        {
            $collection->add('config_city'); // Action gets added automatically
            $collection->remove('edit');
            $collection->remove('list');
            $collection->remove('create');
            $collection->remove('delete');
        }


    }
