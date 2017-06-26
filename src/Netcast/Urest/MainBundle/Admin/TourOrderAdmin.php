<?php

namespace Netcast\Urest\MainBundle\Admin;

use Netcast\Urest\MainBundle\Admin\BasicAdmin as Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class TourOrderAdmin extends Admin {

    public function createQuery($context = 'list') {
        $query = parent::createQuery($context);
        $query
            ->andWhere($query->getRootAlias().'.payed = :payed')
            ->setParameter('payed', true)
        ;
        return $query;
    }

    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('tour_date')
            ->add('tour_date.tour')
            ->add('date_create')
            ->add('user')
        ;


    }

    // Поля, отображаемые в списках
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id','text',['label' => 'form.label.number'])
            ->add('tour_date.tour', null, ['label' => 'form.label.tour'])
            ->add('user', null, ['label' => 'form.label.author', 'template' => 'SonataMediaBundle:MediaAdmin:list_custom.html.twig'])
            ->add('date_create', null, ['label' => 'admin.layout.date_create'])
            ->add('_action', 'actions', [
                'actions' => [
                    'view'   => [],
                ]
            ])
        ;
    }
}
