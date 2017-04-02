<?php

namespace Netcast\Urest\MainBundle\Admin;

use Netcast\Urest\MainBundle\Admin\BasicAdmin as Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class FaqAdmin extends Admin {

    // перед созданием
    public function prePersist($item)
    {
        $user = $this->getSecurityContext()->getToken()->getUser();
        $item->setUser($user);
        $item->setLang($this->getLanguage());
        $item->setCreated(new \DateTime());
        $item->setUpdated(new \DateTime());
    }

    // перед обновлением
    public function preUpdate($item)
    {
        $item->setUpdated(new \DateTime());
    }

    // Поля, отображаемые в формах create/edit
    protected function configureFormFields(FormMapper $formMapper)
    {
        if ($this->id($this->getSubject())) {
            // EDIT
            $defaultDate = $this->getSubject()->getDatePublish();
        }
        else {
            // CREATE
            $defaultDate = new \DateTime();
        }
        $formMapper
            ->with('admin.tour.left',['class' => 'col-md-6', 'translation_domain' => 'NetcastUrestMainBundle'])
            ->add('question', 'textarea', [
                'label' => 'form.label.question',
                'required' => true
            ])
            ->add('answer', 'textarea', [
                'label' => 'form.label.answer',
                'required' => true
            ])
            ->add('datePublish', 'sonata_type_date_picker', [
                'label' => 'form.label.date_publish',
                'data' => $defaultDate,
            ])
            ->add('active', 'checkbox', [
                'label' => 'form.label.active',
                'required' => false
            ])
            ->end()
        ;
    }

    // Поля, отображаемые в формах фильтров
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('active', null, ['label' => 'form.label.active'])
            ->add('user', null, ['label' => 'form.label.author'])
        ;
    }

    public function createQuery($context = 'list') {
        $query = parent::createQuery($context);
        if(!$this->showDelete)
        {
            $query
                ->andWhere($query->getRootAlias().'.deleted = :deleted')
                ->setParameter('deleted', false);
            ;
        }

        return $query;
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('restore', $this->getRouterIdParameter().'/restore');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id','text',['label' => 'form.label.number'])
            ->add('question', null, ['label' => 'form.label.question'])
            ->add('user', 'string', ['label' => 'form.label.author', 'template' => 'SonataMediaBundle:MediaAdmin:list_custom.html.twig'])
            ->add('created', null, ['label' => 'form.label.created'])
            ->add('active', null, ['label' => 'form.label.active'])
            ->add('_action', 'actions', [
                'actions' => [
                    'restore' => ['template' => 'NetcastUrestMainBundle:CRUD:list__action_restore.html.twig'],
                    'edit'   => ['template' => 'NetcastUrestMainBundle:CRUD:list__action_edit.html.twig'],
                    'delete' => ['template' => 'NetcastUrestMainBundle:CRUD:list__action_delete.html.twig'],
                ]
            ])
        ;
    }
}
