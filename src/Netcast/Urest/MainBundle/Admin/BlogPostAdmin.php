<?php

namespace Netcast\Urest\MainBundle\Admin;

use Netcast\Urest\MainBundle\Admin\BasicAdmin as Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\Validator\Constraints\NotBlank;

class BlogPostAdmin extends Admin
{
    /*public function getRole()
    {
        return 'ROLE_ADD_EDIT_BLOG_ARTICLE_META';
    }*/

    // перед созданием
    public function prePersist($item)
    {
        $user = $this->getSecurityContext()->getToken()->getUser();
        $item->setUser($user);
        $item->setCreated(new \DateTime());
        $item->setUpdated(new \DateTime());

        foreach($item->getPostContent() as $postContent) {
            if(!$postContent->getIsDeleted())
                $postContent->setPost($item);
            else
                $item->removeTourContent($postContent);
        }
        foreach ($item->getImages() as $blogImages) {
            if ($blogImages->getMedia() !== null) {
                $blogImages->setPost($item);
            } else {
                $item->removeImage($blogImages);
            }
        }
        foreach ($item->getVideo() as $video) {
            if ($video->getMedia()) {
                $video->setPost($item);
            }
        }

    }

    // перед обновлением
    public function preUpdate($item)
    {
        $item->setUpdated(new \DateTime());
        foreach($item->getPostContent() as $postContent) {
            if(!$postContent->getIsDeleted())
                $postContent->setPost($item);
            else
                $item->removeTourContent($postContent);
        }

        foreach($item->getImages() as $blogImages) {
            if($blogImages->getMedia() !== null)
                $blogImages->setPost($item);
            else
                $item->removeImage($blogImages);
        }
        foreach($item->getVideo() as $video) {
            if($video->getMedia())
                $video->setPost($item);
            else
                $item->removeVideo($video);
        }
    }

    // Поля, отображаемые в формах create/edit
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper = $this->checkAlias($formMapper);

        $post = $this->getSubject();
        $datePublished = ($post->getDatePublish() != null)?$post->getDatePublish():new \DateTime();
        $formMapper
            ->with('admin.tour.left',['class' => 'col-md-6', 'translation_domain' => 'NetcastUrestMainBundle'])
            ->add('alias', 'text', [
                'label' => 'form.label.alias',
                'trim' => true,
                'required' => true
            ])
            ->add('category', 'entity', [
                'class' => 'Netcast\Urest\MainBundle\Entity\BlogCategory',
                'query_builder' => function($repository) {
                        return $repository->createQueryBuilder('bc')
                            ->where('bc.lang=:lang')
                            ->setParameter('lang',$this->getLanguage())
                            ->orderBy('bc.id', 'ASC');
                    },
                'property' => 'title',
                'label' => 'form.label.blog_category',
                'required' => true,
            ])
            ->add('tags', 'urest_collection', [
                'label' => 'form.label.blog_tags',
                'translation_domain' => 'NetcastUrestMainBundle',
                'type' => 'entity',
                'allow_delete' => true,
                'options' => [
                    'class' => 'Netcast\Urest\MainBundle\Entity\BlogTag',
                    'label' => false,
                    'required' => false
                ],
                'by_reference' => false,
                'allow_add' => true,
                'allow_delete' => true,
                'required' => false
            ])
            ->end()
            ->with('admin.tour.right',['class' => 'col-md-6', 'translation_domain' => 'NetcastUrestMainBundle'])
            ->add('coordinates', 'text', [
                'label' => 'form.label.coordinates',
                'trim' => true,
                'required' => true
            ])
            ->add('user', 'label_text', [
                'label' => 'form.label.author',
                'trim' => true,
                'required' => false,
                'data' => ($this->getSubject()->getUser() !== null)?$this->getSecurityContext()->getToken()->getUser():$this->getSubject()->getUser(),
                'mapped' => false
            ])
            ->add('datePublish', 'sonata_type_date_picker', [
                'label' => 'form.label.date_publish',
                'data' => $datePublished
            ])
            ->end()
            ->with('admin.empty',['class' => 'clear', 'translation_domain' => 'NetcastUrestMainBundle'])
            ->add('clear','hidden',['mapped' => false])
            ->end()
            ->with('admin.tour.end',['class' => 'col-md-12', 'translation_domain' => 'NetcastUrestMainBundle'])
            ->add('postContent', 'urest_i18n_collection', [
                'label' => 'form.label.content',
                'type' => 'netcast_urest_content_form',
                'options' => [
                    'label' => false,
                    'required' => false,
                    'data_class' => 'Netcast\Urest\MainBundle\Entity\BlogPostContent',
                ],
                'by_reference' => false,
                'allow_add' => true,
                'allow_delete' => false,
                'required' => false
            ])
            ->add('locator_icon', 'urest_media_type', [
                'label' => 'form.label.blog_locator_icon',
                'provider' => 'sonata.media.provider.image',
                'translation_domain' => 'NetcastUrestMainBundle',
                'required' => false
            ])
            ->add('active', 'checkbox', [
                'label' => 'form.label.active',
                'required' => false
            ])
            ->add('images', 'urest_collection', [
                'label' => 'form.label.images',
                'type' => 'netcast_urest_media_collection_form',
                'options' => [
                    'label' => false,
                    'required' => false,
                    'data_class' => 'Netcast\Urest\MainBundle\Entity\BlogPostImages',
                ],
                'by_reference' => false,
                'allow_add' => true,
                'allow_delete' => false,
                'required' => false
            ])
            ->add('video', 'urest_collection', [
                'label' => 'form.label.video',
                'type' => 'netcast_urest_media_collection_form',
                'options' => [
                    'label' => false,
                    'required' => false,
                    'data_class' => 'Netcast\Urest\MainBundle\Entity\BlogPostVideo',
                    'provider' => 'sonata.media.provider.youtube'
                ],
                'by_reference' => false,
                'allow_add' => true,
                'allow_delete' => false,
                'required' => false
            ])
            ->end();
        ;
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('restore', $this->getRouterIdParameter() . '/restore');
    }

    public function createQuery($context = 'list', $withDelete = false)
    {
        $query = parent::createQuery($context);
        if (!$this->showDelete) {
            $query
                ->andWhere($query->getRootAlias().'.deleted = :deleted')
                ->setParameter('deleted', false);
            ;
        }
        return $query;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id','text',['label' => 'form.label.number'])
            ->add('content', null, ['label' => 'form.label.title'])
            ->add('category', null, ['label' => 'form.label.blog_category', 'template' => 'SonataMediaBundle:MediaAdmin:list_custom.html.twig'])
            ->add('tags', null, ['label' => 'form.label.blog_tags'])
            ->add('active', null, ['label' => 'form.label.active'])
            ->add('user', 'string', ['label' => 'form.label.author', 'template' => 'SonataMediaBundle:MediaAdmin:list_custom.html.twig'])
            ->add('created', null, ['label' => 'form.label.created'])
            ->add('updated', null, ['label' => 'form.label.updated'])
            ->add('_action', 'actions', [
                'actions' => [
                    'restore' => ['template' => 'NetcastUrestMainBundle:CRUD:list__action_restore.html.twig'],
                    'edit'   => ['template' => 'NetcastUrestMainBundle:CRUD:list__action_edit.html.twig'],
                    'delete' => ['template' => 'NetcastUrestMainBundle:CRUD:list__action_delete.html.twig']
                ]
            ])
        ;
    }
}