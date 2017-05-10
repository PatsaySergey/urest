<?php

namespace Netcast\Urest\MainBundle\Admin;

use Netcast\Urest\MainBundle\Admin\BasicAdmin as Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class TourAdmin extends Admin {

    public function removeTourImages($post) {
        $images = $post->getRemovedImages();
        if ($images) {
            foreach ($images as $image) {
                $this->em->remove($image);
            }
        }
    }


    public function prePersist($post)
    {
        $user = $this->getSecurityContext()->getToken()->getUser();
        $post->setUser($user);
        $post->setCreated(new \DateTime());

        foreach($post->getTourDates() as $tourDate) {
            if($tourDate->getPrice() !== null)
                $tourDate->setTour($post);
            else
                $post->removeTourDate($tourDate);
        }
        foreach($post->getTourContent() as $tourContent) {
            if($tourContent->getDescription() !== null)
                $tourContent->setTour($post);
            else
                $post->removeTourContent($tourContent);
        }
        foreach($post->getTourImages() as $tourImages) {
            if($tourImages->getMedia() !== null)
                $tourImages->setTour($post);
            else
                $post->removeTourImage($tourImages);
        }
        foreach($post->getTourVideo() as $tourImages) {
            if($tourImages->getMedia() !== null)
                $tourImages->setTour($post);
            else
                $post->removeTourVideo($tourImages);
        }
    }

    public function preUpdate($post)
    {
        foreach($post->getTourDates() as $tourDate) {
            if($tourDate->getPrice() !== null)
                $tourDate->setTour($post);
            else
                $post->removeTourDate($tourDate);
        }
        foreach($post->getTourContent() as $tourContent) {
            if(!$tourContent->getIsDeleted())
                $tourContent->setTour($post);
            else
                $post->removeTourContent($tourContent);
        }
        foreach($post->getTourImages() as $tourImages) {
            if($tourImages->getMedia() !== null)
                $tourImages->setTour($post);
            else
                $post->removeTourImage($tourImages);
        }
        foreach($post->getTourVideo() as $tourImages) {
            if($tourImages->getMedia() !== null)
                $tourImages->setTour($post);
            else
                $post->removeTourVideo($tourImages);
        }
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $city = $this->getSubject()->getCity();
        $region = (null === $city)?$city:$city->getRegion();
        $country = (null === $city)?$city:$city->getRegion()->getCountry();

        $datePublish = $this->getSubject()->getDatePublish();
        $datePublish = ($datePublish === null)?new \DateTime():$datePublish;

        $formMapper
            ->with('admin.tour.left',['class' => 'col-md-6', 'translation_domain' => 'NetcastUrestMainBundle'])
            ->add('country', 'entity', [
                'class' => 'Netcast\Urest\MainBundle\Entity\Country',
                'query_builder' => function($repository) {
                        return $repository->createQueryBuilder('c')
                            ->where('c.lang=:lang')
                            ->setParameter('lang', $this->getLanguage())
                            ->orderBy('c.title', 'ASC');
                    },
                'property' => 'title',
                'attr' => [
                    'class' => 'country_entity_field'
                ],
                'data' => $country,
                'empty_data' => '',
                'empty_value' => '',
                'label' => 'form.label.country',
                'required' => true,
                'mapped'  => false,
            ])

            ->add('region', 'entity', [
                'class' => 'Netcast\Urest\MainBundle\Entity\Region',
                'query_builder' => function($repository) {
                        return $repository->createQueryBuilder('r')
                            ->where('r.lang=:lang')
                            ->setParameter('lang',$this->getLanguage())
                            ->orderBy('r.title', 'ASC');
                    },
                'property' => 'title',
                'attr' => [
                    'class' => 'region_entity_field'
                ],
                'label' => 'form.label.region',
                'required' => true,
                'empty_data' => '',
                'empty_value' => '',
                'data' => $region,
                'mapped'  => false,
            ])
            ->add('city', 'entity', [
                'class' => 'Netcast\Urest\MainBundle\Entity\City',
                'query_builder' => function($repository) {
                        return $repository->createQueryBuilder('c')
                            ->where('c.lang=:lang')
                            ->setParameter('lang',$this->getLanguage())
                            ->orderBy('c.id', 'ASC');
                    },
                'property' => 'title',
                'attr' => [
                    'class' => 'city_entity_field'
                ],
                'label' => 'form.label.city',
                'empty_data' => '',
                'empty_value' => '',
                'required' => true
            ])
            ->add('coordinates', 'text', [
                'label' => 'form.label.coordinates',
                'trim' => true,
                'required' => false
            ])
            ->add('active', 'checkbox', [
                'label' => 'form.label.active',
                'required' => false
            ])
            ->add('show_in_builder', 'checkbox', [
                'label' => 'form.label.show_in_builder',
                'required' => false
            ])
            ->add('hot_offer', 'checkbox', [
                'label' => 'form.label.hot_offer',
                'required' => false
            ])
            ->add('icon', 'urest_media_type', [
                'label' => 'form.label.icon',
                'provider' => 'sonata.media.provider.image',
                'translation_domain' => 'NetcastUrestMainBundle',
                'required' => false
            ])
            ->end()
            ->with('admin.tour.right',['class' => 'col-md-6', 'translation_domain' => 'NetcastUrestMainBundle'])
            ->add('datePublish', 'sonata_type_date_picker', [
                'label' => 'form.label.date_publish',
                'format' => 'yyyy-MM-dd',
                'model_timezone'=>'Europe/Kiev',
                'view_timezone'=>'Europe/Kiev',
                'data' => $datePublish
            ])
            ->add('user', 'label_text', [
                'label' => 'form.label.author',
                'trim' => true,
                'required' => false,
                'data' => ($this->getSubject()->getUser() !== null)?$this->getSecurityContext()->getToken()->getUser():$this->getSubject()->getUser(),
                'mapped' => false
            ])

            ->add('tourDates', 'urest_collection', [
                'label' => 'form.label.dates',
                'type' => 'netcast_urest_tour_dates_form',
                'options' => [
                    'data_class' => 'Netcast\Urest\MainBundle\Entity\TourDates',
                    'translation_domain' => 'NetcastUrestMainBundle',
                    'label' => false,
                    'required' => false
                ],
                'by_reference' => false,
                'allow_add' => true,
                'allow_delete' => false,
                'required' => false
            ])
            ->end()
            ->with('admin.empty',['class' => 'clear', 'translation_domain' => 'NetcastUrestMainBundle'])
            ->add('clear','hidden',['mapped' => false])
            ->end()
            ->with('admin.tour.end',['class' => 'col-md-12', 'translation_domain' => 'NetcastUrestMainBundle'])

            ->add('tourContent', 'urest_i18n_collection', [
                'label' => 'form.label.content',
                'type' => 'netcast_urest_content_form',
                'options' => [
                    'label' => false,
                    'required' => false,
                    'data_class' => 'Netcast\Urest\MainBundle\Entity\TourContent',
                ],
                'by_reference' => false,
                'allow_add' => true,
                'allow_delete' => false,
                'required' => false
            ])

            ->add('tourImages', 'urest_collection', [
                'label' => 'form.label.images',
                'type' => 'netcast_urest_media_collection_form',
                'options' => [
                    'label' => false,
                    'required' => false,
                    'data_class' => 'Netcast\Urest\MainBundle\Entity\TourImages',
                ],
                'by_reference' => false,
                'allow_add' => true,
                'allow_delete' => false,
                'required' => false
            ])
            ->add('tourVideo', 'urest_collection', [
                'label' => 'form.label.video',
                'type' => 'netcast_urest_media_collection_form',
                'options' => [
                    'label' => false,
                    'required' => false,
                    'data_class' => 'Netcast\Urest\MainBundle\Entity\TourVideo',
                    'provider' => 'sonata.media.provider.youtube'
                ],
                'by_reference' => false,
                'allow_add' => true,
                'allow_delete' => false,
                'required' => false
            ])
            ->end()
        ;
    }


    // Поля, отображаемые в списках
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id','text',['label' => 'form.label.number'])
            ->add('title', null, ['label' => 'form.label.title'])
            ->add('city', null, ['label' => 'admin.layout.city', 'template' => 'SonataMediaBundle:MediaAdmin:list_custom.html.twig'])
            ->add('accommodation', null, ['label' => 'admin.layout.accommodation'])

            ->add('active', null, ['label' => 'form.label.active'])
            ->add('user', null, ['label' => 'form.label.author', 'template' => 'SonataMediaBundle:MediaAdmin:list_custom.html.twig'])
            ->add('_action', 'actions', [
                'actions' => [
                    'edit'   => ['template' => 'NetcastUrestMainBundle:CRUD:list__action_edit.html.twig'],
                    'delete' => ['template' => 'NetcastUrestMainBundle:CRUD:list__action_delete.html.twig'],
                ]
            ])
        ;
    }
}
