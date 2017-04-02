<?php

namespace Netcast\Urest\MainBundle\Admin;

use Netcast\Urest\MainBundle\Admin\BasicAdmin as Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class FGVAdmin extends Admin {

    public function prePersist($post)
    {
        $post->setLang($this->getLanguage());
        $media = $post->getMedia();
        $media->setName($post->getTitle());
        $post->setMedia($media);
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
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
            ->add('active', 'checkbox', [
                'label' => 'form.label.active',
                'required' => false
            ])
            ->add('media', 'sonata_media_type', [
                'label' => 'form.label.video',
                'provider' => 'sonata.media.provider.youtube',
                'translation_domain' => 'NetcastUrestMainBundle',
                'context'  => 'default',
                'required' => false
            ])
            ->end()
        ;
    }



    public function createQuery($context = 'list') {
        $query = parent::createQuery($context);
        $query
            ->andWhere($query->getRootAlias().'.lang = :lang')
            ->setParameter('lang', $this->getLanguage())
        ;

        return $query;
    }

    // Поля, отображаемые в списках
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id','text',['label' => 'form.label.number'])
            ->add('title', null, ['label' => 'form.label.title'])
            ->add('active', null, ['label' => 'form.label.active'])
            ->add('_action', 'actions', [
                'actions' => [
                    'edit'   => ['template' => 'NetcastUrestMainBundle:CRUD:list__action_edit.html.twig'],
                    'delete' => ['template' => 'NetcastUrestMainBundle:CRUD:list__action_delete.html.twig'],
                ]
            ])
        ;
    }
}
