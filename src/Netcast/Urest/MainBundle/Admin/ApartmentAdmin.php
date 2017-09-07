<?php

namespace Netcast\Urest\MainBundle\Admin;

use Netcast\Urest\MainBundle\Admin\BasicAdmin as Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Validator\Constraints\NotBlank;

class ApartmentAdmin extends Admin
    {

    // перед созданием
    public function prePersist($item)
    {

        $user = $this->getSecurityContext()->getToken()->getUser();
        $item->setUser($user);
        $item->setCreated(new \DateTime());
        $item->setUpdated(new \DateTime());
        $this->toPositive($item);
        foreach($item->getImages() as $img) {
            if ($img->getMedia() !== null)
                $img->setApartment($item);
            else
                $item->removeImage($img);
        }
        foreach($item->getApartmentContent() as $content) {
            if(!$content->getIsDeleted())
                $content->setParent($item);
            else
                $item->removeCityContent($content);
        }
    }

    // перед обновлением
    public function preUpdate($item)
    {
        $this->toPositive($item);
        $item->setUpdated(new \DateTime());
        foreach($item->getImages() as $img) {
            if ($img->getMedia() !== null)
                $img->setApartment($item);
            else
                $item->removeImage($img);
        }
        foreach($item->getApartmentContent() as $content) {
            if(!$content->getIsDeleted())
                $content->setParent($item);
            else
                $item->removeCityContent($content);
        }
    }

    // Поля, отображаемые в формах create/edit
    protected function configureFormFields(FormMapper $formMapper)
    {
        $city = $this->getSubject()->getCity();
        $region = (null === $city)?$city:$city->getRegion();
        $country = (null === $city)?$city:$city->getRegion()->getCountry();

        $formMapper
            ->with('admin.tour.left',['class' => 'col-md-6', 'translation_domain' => 'NetcastUrestMainBundle'])
            ->add('types', 'entity', [
                'class' => 'Netcast\Urest\MainBundle\Entity\ApartmentType',
                'property' => 'title',
                'label' => 'form.label.apartment_type',
                'required' => true,
            ])
            ->add('rooms_count', 'choice', [
                'label' => 'form.label.rooms',
                'choices' =>
                    [
                        '1' => '1',
                        '2' => '2',
                        '3' => '3',
                        '4' => '4',
                        '5' => '5',
                        'house' => $this->getLanguage()=='en'?'house':'дом',
                    ],
            ])
            ->add('price', 'money', [
                'translation_domain'  => 'NetcastUrestMainBundle',
                'label' => 'form.label.price',
                'precision' => 2,
                'invalid_message' => 'decimal_format',
                'empty_data' => '0.00',
                //'currency' => 'UAH',
                'trim' => true,
                'required' => true,
                'attr' => [
                    'maxlength' => '25',
                    'data-format'=>'price'
                ],
            ])
            ->end()
            ->with('admin.tour.right',['class' => 'col-md-6', 'translation_domain' => 'NetcastUrestMainBundle'])
            ->add('country', 'entity', [
                'class' => 'Netcast\Urest\MainBundle\Entity\Country',
                'property' => 'content',
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
                'property' => 'content',
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
                'property' => 'content',
                'attr' => [
                    'class' => 'city_entity_field'
                ],
                'label' => 'form.label.city',
                'empty_data' => '',
                'empty_value' => '',
                'required' => true
            ])
            ->end()
            ->with('admin.empty',['class' => 'clear', 'translation_domain' => 'NetcastUrestMainBundle'])
            ->add('clear','hidden',['mapped' => false])
            ->end()
            ->with('admin.tour.end',['class' => 'col-md-12', 'translation_domain' => 'NetcastUrestMainBundle'])
            ->add('apartmentContent', 'urest_i18n_collection', [
                'label' => 'form.label.content',
                'type' => 'netcast_urest_title_content_form',
                'options' => [
                    'label' => false,
                    'required' => false,
                    'data_class' => 'Netcast\Urest\MainBundle\Entity\ApartmentContent',
                ],
                'by_reference' => false,
                'allow_add' => true,
                'allow_delete' => false,
                'required' => false
            ])
            ->add('images', 'urest_collection', [
                'label' => 'form.label.images',
                'type' => 'netcast_urest_media_collection_form',
                'options' => [
                    'label' => false,
                    'required' => false,
                    'data_class' => 'Netcast\Urest\MainBundle\Entity\ApartmentImages',
                ],
                'by_reference' => false,
                'allow_add' => true,
                'allow_delete' => false,
                'required' => false
            ])
            ->add('video', 'urest_collection', [
                'label' => 'form.label.video',
                'type' => 'sonata_media_type',
                'options' => [
                    'label' => false,
                    'required' => false,
                    'data_class' => 'Application\Sonata\MediaBundle\Entity\Media',
                    'provider' => 'sonata.media.provider.youtube'
                ],
                'by_reference' => false,
                'allow_add' => true,
                'allow_delete' => false,
                'required' => false
            ])
            ->add('active', 'checkbox', [
                'label' => 'form.label.active',
                'required' => false
            ])
            ->end()
        ;
    }


    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id','text',['label' => 'form.label.number'])
            ->add('content', null, ['label' => 'form.label.title'])
            ->add('types', null, ['label' => 'form.label.apartment_type'])
            ->add('rooms_count', 'text', ['label' => 'form.label.rooms'])
            ->add('country','string',['label'=>'form.label.country', 'template' => 'NetcastUrestMainBundle:CRUD:list_country.html.twig'])
            ->add('city', null, ['label' => 'form.label.city', 'template' => 'SonataMediaBundle:MediaAdmin:list_custom.html.twig'])
            ->add('_action', 'actions', [
                'actions' => [
                    'edit'   => ['template' => 'NetcastUrestMainBundle:CRUD:list__action_edit.html.twig'],
                    'delete' => ['template' => 'NetcastUrestMainBundle:CRUD:list__action_delete.html.twig'],
                ]
            ])
        ;
    }

}