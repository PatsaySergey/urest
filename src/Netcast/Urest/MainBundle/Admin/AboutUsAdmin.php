<?php

namespace Netcast\Urest\MainBundle\Admin;

use Netcast\Urest\MainBundle\Admin\BasicAdmin as Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Validator\Constraints\NotBlank;
use Sonata\AdminBundle\Route\RouteCollection;
use Doctrine\ORM\EntityManager;

class AboutUsAdmin extends Admin {


    /**
     * Entity Manager
     * @var EntityManager
     */
    protected  $em;


    // перед созданием
    public function prePersist($item)
    {
        $user = $this->getSecurityContext()->getToken()->getUser();
        $item->setUser($user);
        $item->setCreated(new \DateTime());
        $item->setUpdated(new \DateTime());

        foreach($item->getAboutContent() as $aContent) {
            if(!$aContent->getIsDeleted())
                $aContent->setParent($item);
            else
                $item->removeAboutContent($aContent);
        }
    }

    // перед обновлением
    public function preUpdate($item)
    {
        $item->setUpdated(new \DateTime());
        foreach($item->getAboutContent() as $aContent) {
            if(!$aContent->getIsDeleted())
                $aContent->setParent($item);
            else
                $item->removeAboutContent($aContent);
        }
    }

    // Поля, отображаемые в формах create/edit
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('image', 'urest_media_type', [
                'label' => 'form.label.image',
                'provider' => 'sonata.media.provider.image',
                'translation_domain' => 'NetcastUrestMainBundle',
                'required' => false
            ])
            ->add('aboutContent', 'urest_i18n_collection', [
                'label' => 'form.label.content',
                'type' => 'netcast_urest_title_content_form',
                'options' => [
                    'label' => false,
                    'required' => false,
                    'data_class' => 'Netcast\Urest\MainBundle\Entity\AboutUsContent',
                ],
                'by_reference' => false,
                'allow_add' => true,
                'allow_delete' => false,
                'required' => false
            ])
        ;
    }

    // Поля, отображаемые в формах фильтров
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('user', null, ['label' => 'form.label.author'])
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

    protected function configureRoutes(RouteCollection $collection)
    {
        //$collection->remove('create');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id','text',['label' => 'form.label.number'])
            ->add('content', null, ['label' => 'form.label.title'])
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
