<?php

namespace Netcast\Urest\MainBundle\Admin;

use Netcast\Urest\MainBundle\Admin\BasicAdmin as Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class CountryAdmin extends Admin
{

    // перед созданием
    public function prePersist($item)
    {
        $user = $this->getSecurityContext()->getToken()->getUser();

        $item->setUser($user);
        $item->setCreated(new \DateTime());
        $item->setUpdated(new \DateTime());
        foreach($item->getCountryContent() as $tagContent) {
            if(!$tagContent->getIsDeleted())
                $tagContent->setParent($item);
            else
                $item->removeCountryContent($tagContent);
        }
    }

    // перед обновлением
    public function preUpdate($item)
    {
        $item->setUpdated(new \DateTime());
        foreach($item->getCountryContent() as $tagContent) {
            if(!$tagContent->getIsDeleted())
                $tagContent->setParent($item);
            else
                $item->removeCountryContent($tagContent);
        }
    }

    // Поля, отображаемые в формах create/edit
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('admin.tour.left',['class' => 'col-md-6', 'translation_domain' => 'NetcastUrestMainBundle'])
            ->add('countryContent', 'urest_i18n_collection', [
                'label' => 'form.label.content',
                'type' => 'netcast_urest_title_one_content_form',
                'options' => [
                    'label' => false,
                    'required' => false,
                    'data_class' => 'Netcast\Urest\MainBundle\Entity\CountryContent',
                ],
                'by_reference' => false,
                'allow_add' => true,
                'allow_delete' => false,
                'required' => false
            ])
            ->add('coordinates', 'text', [
                'label' => 'form.label.coordinates',
                'trim' => true,
                'required' => true
            ])
            ->end()
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id','text',['label' => 'form.label.number'])
            ->add('content', null, ['label' => 'form.label.title'])
            ->add('coordinates', null, ['label' => 'form.label.coordinates'])
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