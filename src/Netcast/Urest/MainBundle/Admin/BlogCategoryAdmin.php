<?php

namespace Netcast\Urest\MainBundle\Admin;

use Netcast\Urest\MainBundle\Admin\BasicAdmin as Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class BlogCategoryAdmin extends Admin
{

    // перед созданием
    public function prePersist($item)
    {
        $user = $this->getSecurityContext()->getToken()->getUser();
        $item->setUser($user);
        $item->setLang($this->getLanguage());
        $item->setCreated(new \DateTime());
        $item->setUpdated(new \DateTime());
        foreach($item->getCategoryContent() as $postContent) {
            if(!$postContent->getIsDeleted())
                $postContent->setParent($item);
            else
                $item->removeTourContent($postContent);
        }
    }

    // перед обновлением
    public function preUpdate($item)
    {
        foreach($item->getCategoryContent() as $postContent) {
            if(!$postContent->getIsDeleted())
                $postContent->setParent($item);
            else
                $item->removeTourContent($postContent);
        }
        $item->setUpdated(new \DateTime());
    }

    // Поля, отображаемые в формах create/edit
    protected function configureFormFields(FormMapper $formMapper)
    {
        $this->checkAlias($formMapper);

        $formMapper
            ->add('categoryContent', 'urest_i18n_collection', [
                'label' => 'form.label.content',
                'type' => 'netcast_urest_title_one_content_form',
                'options' => [
                    'label' => false,
                    'required' => false,
                    'data_class' => 'Netcast\Urest\MainBundle\Entity\BlogCategoryContent',
                ],
                'by_reference' => false,
                'allow_add' => true,
                'allow_delete' => false,
                'required' => false
            ])
            ->add('alias', 'text', [
                'label'    => 'form.label.alias',
                'trim'     => true,
                'required' => true
            ])

        ;
    }


    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id', 'text', ['label' => 'form.label.number'])
            ->add('content', null, ['label' => 'form.label.title'])
            ->add('user', 'string', [
                'label'    => 'form.label.author',
                'template' => 'SonataMediaBundle:MediaAdmin:list_custom.html.twig',
            ])
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