<?php

namespace Netcast\Urest\MainBundle\Admin;

use Netcast\Urest\MainBundle\Admin\BasicAdmin as Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Validator\Constraints\NotBlank;
use Sonata\AdminBundle\Route\RouteCollection;
use Doctrine\ORM\EntityManager;

class CurrencyRateAdmin extends Admin {


    /**
     * Entity Manager
     * @var EntityManager
     */
    protected  $em;

    // перед созданием
    public function prePersist($item)
    {
        $item->setLang($this->getLanguage());
    }


    // Поля, отображаемые в формах create/edit
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('admin.tour.left',['class' => 'col-md-6', 'translation_domain' => 'NetcastUrestMainBundle'])
            ->add('currency_code', 'text', [
                'label' => 'form.label.currency_code',
                'constraints' => [new NotBlank()]
            ])
            ->add('currency_icon', 'text', [
                'label' => 'form.label.currency_icon',
                'constraints' => [new NotBlank()]
            ])
            ->add('rate', 'text', [
                'label' => 'form.label.rate',
                'constraints' => [new NotBlank()]
            ])
            ->add('display', 'checkbox', [
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
            ->add('currency_code', null, ['label' => 'form.label.currency_code'])
        ;
    }

    /**
     * Set entity manager
     * @param \Doctrine\ORM\EntityManager $em
     */
    public function setEntityManager(EntityManager $em) {
        $this->em = $em;
    }

    public function createQuery($context = 'list') {
        return parent::createQuery($context);
    }


    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id','text',['label' => 'form.label.number'])
            ->add('currency_code', null, ['label' => 'form.label.currency_code'])
            ->add('rate', null, ['label' => 'form.label.rate'])
            ->add('_action', 'actions', [
                'actions' => [
                    'edit'   => ['template' => 'NetcastUrestMainBundle:CRUD:list__action_edit.html.twig'],
                    'delete' => ['template' => 'NetcastUrestMainBundle:CRUD:list__action_delete.html.twig'],
                ]
            ])
        ;
    }
}
