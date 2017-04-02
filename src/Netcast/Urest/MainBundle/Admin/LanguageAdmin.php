<?php

namespace Netcast\Urest\MainBundle\Admin;

use Netcast\Urest\MainBundle\Admin\BasicAdmin as Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class LanguageAdmin extends Admin {

    // Поля, отображаемые в формах create/edit
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper = $this->checkAlias($formMapper);
        $formMapper
            ->with('admin.tour.left',['class' => 'col-md-6', 'translation_domain' => 'NetcastUrestMainBundle'])
            ->add('title', 'text', [
                'label' => 'form.label.title',
                'trim' => true,
                'required' => true,
                'attr' => [
                    'maxlength' => '255',
                ],
            ])
            ->add('alias', 'text', [
                'label' => 'form.label.alias',
                'attr' => [
                    'maxlength' => '2',
                ],
                'trim' => true,
                'required' => true
            ])
            ->add('active', 'checkbox', [
                'label' => 'form.label.active_lang',
                'required' => false
            ])
            ->add('display', 'checkbox', [
                'label' => 'form.label.show_lang',
                'required' => false
            ])
            ->end()
        ;
    }

    // Поля, отображаемые в формах фильтров
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('title', null, ['label' => 'form.label.title'])
            ->add('alias', null, ['label' => 'form.label.alias'])
        ;
    }

    // Поля, отображаемые в списках
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id','text',['label' => 'form.label.number'])
            ->add('title', null, ['label' => 'form.label.title'])
            ->add('alias', null, ['label' => 'form.label.alias'])
            ->add('active', null, ['label' => 'form.label.active'])
            ->add('display', null, ['label' => 'form.label.show_lang'])
            ->add('_action', 'actions', [
                'actions' => [
                    'edit'   => ['template' => 'NetcastUrestMainBundle:CRUD:list__action_edit.html.twig'],
                    'delete' => ['template' => 'NetcastUrestMainBundle:CRUD:list__action_delete.html.twig'],
                ]
            ])
        ;
    }
}
