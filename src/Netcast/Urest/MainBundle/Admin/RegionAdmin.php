<?php

namespace Netcast\Urest\MainBundle\Admin;

use Netcast\Urest\MainBundle\Admin\BasicAdmin as Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class RegionAdmin extends Admin
{

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

        $parentCountry = $this->getParentEntity('Netcast\Urest\MainBundle\Entity\Country');

        $formMapper
            ->with('admin.tour.left',['class' => 'col-md-6', 'translation_domain' => 'NetcastUrestMainBundle'])
            ->add('title', 'text', [
                'label' => 'form.label.title',
                'trim' => true,
                'required' => true,
                'attr' => [
                    'maxlength' => '255',
                ],
            ]);
        if($parentCountry !== null)
        {
            $formMapper->add('country', 'entity', [
                'class' => 'Netcast\Urest\MainBundle\Entity\Country',
                'query_builder' => function($repository) {
                        return $repository->createQueryBuilder('c')
                            ->where('c.lang=:lang')
                            ->setParameter('lang',$this->getLanguage())
                            ->orderBy('c.id', 'ASC');
                    },
                'property' => 'title', // property from Country, may be 'alias'
                'label' => 'form.label.country',
                'data' => $parentCountry,
                'required' => true,
            ]);
        }
        else{
            $formMapper->add('country', 'entity', [
                'class' => 'Netcast\Urest\MainBundle\Entity\Country',
                'query_builder' => function($repository) {
                        return $repository->createQueryBuilder('c')
                            ->where('c.lang=:lang')
                            ->setParameter('lang',$this->getLanguage())
                            ->orderBy('c.id', 'ASC');
                    },
                'property' => 'title', // property from Country, may be 'alias'
                'label' => 'form.label.country',
                'required' => true,
            ]);
        }
        $formMapper
            ->add('coordinates', 'text', [
                'label' => 'form.label.coordinates',
                'trim' => true,
                'required' => true
            ])
            ->end();
        ;
    }

    // Поля, отображаемые в формах фильтров
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('title', null, ['label' => 'form.label.title'])
            ->add('user', null, ['label' => 'form.label.author'])
        ;
    }

    public function createChildrenQuery($query,$parent)
    {
            $query
                ->andWhere($query->getRootAlias().'.country = :country')
                ->setParameter('country', $parent->getId())
            ;
            return $query;
    }

    public function createQuery($context = 'list') {
        $query = parent::createQuery($context);
        $query
            ->andWhere($query->getRootAlias().'.lang = :lang')
            ->setParameter('lang', $this->getLanguage())
        ;

        return $query;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id','text',['label' => 'form.label.number'])
            ->add('title', null, ['label' => 'form.label.title'])
            ->add('coordinates', null, ['label' => 'form.label.coordinates'])
            ->add('country','string',['label'=>'form.label.country', 'template' => 'SonataMediaBundle:MediaAdmin:list_custom.html.twig'])
            ->add('user', 'string', ['label' => 'form.label.author', 'template' => 'SonataMediaBundle:MediaAdmin:list_custom.html.twig'])
            ->add('created', null, ['label' => 'form.label.created'])
            ->add('_action', 'actions', [
                'actions' => [
                    'edit'   => ['template' => 'NetcastUrestMainBundle:CRUD:list__action_edit.html.twig'],
                    'delete' => ['template' => 'NetcastUrestMainBundle:CRUD:list__action_delete.html.twig'],
                ]
            ])
        ;
    }
}