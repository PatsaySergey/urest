<?php

namespace Netcast\Urest\MainBundle\Admin;

use Netcast\Urest\MainBundle\Admin\BasicAdmin as Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Validator\Constraints\NotBlank;
use Sonata\AdminBundle\Route\RouteCollection;

class ReviewAdmin extends Admin
{
    /**
     * перед созданием
     *
     * @param \Netcast\Urest\MainBundle\Entity\Review $item
     */
    public function prePersist($item)
    {
        $user = $this->getSecurityContext()->getToken()->getUser();
        $item->setUser($user);
        $item->setNew(false);
        $item->setLang($this->getLanguage());
        $item->setCreated(new \DateTime());
        $item->setUpdated(new \DateTime());
    }

    /**
     * перед обновлением
     *
     * @param \Netcast\Urest\MainBundle\Entity\Review $item
     */
    public function preUpdate($item)
    {
        $item->setNew(false);
        $item->setUpdated(new \DateTime());
    }

    /**
     * Поля, отображаемые в формах create/edit
     *
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $now = new \DateTime();
        $formMapper
            ->with('admin.tour.left', array(
                'class'              => 'col-md-4',
                'translation_domain' => 'NetcastUrestMainBundle',
            ))
                ->add('avatar', 'urest_media_type', array(
                    'label'              => 'form.label.avatar',
                    'provider'           => 'sonata.media.provider.image',
                    'translation_domain' => 'NetcastUrestMainBundle',
                    'required'           => false,
                ))
            ->end();
        $formMapper
            ->with('admin.tour.center', array(
                'class'              => 'col-md-4',
                'translation_domain' => 'NetcastUrestMainBundle',
            ))
                ->add('user', 'label_text', array(
                    'label'    => 'admin.layout.user',
                    'trim'     => true,
                    'required' => false,
                    'mapped'   => false,
                    'data'     => $this->getSecurityContext()->getToken()->getUser(),
                    'mapped'   => false,
                ))
                ->add('nickname', 'text', array(
                    'label'    => 'form.label.nickname',
                    'required' => false,
                ))
            ->end();
        $formMapper
            ->with('admin.tour.right', array(
                'class'              => 'col-md-4',
                'translation_domain' => 'NetcastUrestMainBundle',
            ))
                ->add('created', 'label_text', array(
                    'label'    => 'form.label.created',
                    'trim'     => true,
                    'required' => false,
                    'data'     => ($this->getSubject()->getCreated() !== null) ? $this->getSubject()->getCreated() : $now,
                    'mapped'   => false,
                ))
                ->add('updated', 'label_text', array(
                    'label'    => 'form.label.updated',
                    'trim'     => true,
                    'required' => false,
                    'data'     => ($this->getSubject()->getUpdated() !== null) ? $this->getSubject()->getUpdated() : $now,
                    'mapped'   => false,
                ))
            ->end();
        $formMapper
            ->with('admin.empty', array(
                'class'              => 'clear',
                'translation_domain' => 'NetcastUrestMainBundle',
            ))
                ->add('clear', 'hidden', array(
                    'mapped' => false,
                ))
            ->end();
        $formMapper
            ->with('admin.tour.end', array(
                'class'              => 'col-md-12',
                'translation_domain' => 'NetcastUrestMainBundle',
            ))
                ->add('review', 'ckeditor', array(
                    'label'       => 'form.label.description',
                    'trim'        => true,
                    'constraints' => array(new NotBlank()),
                    'required'    => true,
                ));
        if ($this->getSecurityContext()->isGranted('ROLE_ADD_REVIEWS')) {
            $formMapper->add('on_main', 'checkbox', array(
                'label'    => 'form.label.on_main',
                'required' => false,
            ));
        }
        if ($this->getSecurityContext()->isGranted('ROLE_MODERATE_REVIEWS')) {
            $formMapper->add('active', 'checkbox', array(
                'label'    => 'form.label.active',
                'required' => false,
            ));
        }
        $formMapper->end();
    }

    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);

        if (!$this->showDelete) {
            $query
                ->andWhere($query->getRootAlias() . '.deleted = :deleted')
                ->setParameter('deleted', false);
        }

        return $query;
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('restore', $this->getRouterIdParameter() . '/restore');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id', 'text', array(
                'label' => 'form.label.number',
            ))
            ->add('review', null, array(
                'label'    => 'admin.layout.review',
                'template' => 'NetcastUrestMainBundle:Admin:urest_html.html.twig',
            ))
            ->add('on_main', null, array(
                'label' => 'form.label.on_main',
            ))
            ->add('user', 'string', array(
                'label'    => 'admin.layout.user',
                'template' => 'SonataMediaBundle:MediaAdmin:list_custom.html.twig',
            ))
            ->add('created', null, array(
                'label' => 'form.label.created',
            ))
            ->add('_action', 'actions', array(
                'actions' => array(
                    'restore' => array('template' => 'NetcastUrestMainBundle:CRUD:list__action_restore.html.twig'),
                    'edit'    => array('template' => 'NetcastUrestMainBundle:CRUD:list__action_edit.html.twig'),
                    'delete'  => array('template' => 'NetcastUrestMainBundle:CRUD:list__action_delete.html.twig'),
                ),
            ))
        ;
    }
}