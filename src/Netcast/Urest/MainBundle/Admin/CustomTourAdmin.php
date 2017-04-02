<?php

namespace Netcast\Urest\MainBundle\Admin;

use Netcast\Urest\MainBundle\Admin\BasicAdmin as Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Netcast\Urest\MainBundle\Entity\HotelRoom;
use Netcast\Urest\MainBundle\Entity\Apartment;
use Netcast\Urest\MainBundle\Form\Type\AddHomeFormType;

class CustomTourAdmin extends Admin {

    protected $isNewOrders = true;
    protected $em;

    /**
     * Remove "create" routes and add accept/decline routes
     * @param \Sonata\AdminBundle\Route\RouteCollection $collection
     */
    public function configureRoutes(RouteCollection $collection) {
        parent::configureRoutes($collection);
        $collection
            ->remove('create')
            ->add('take','{objectId}/take');
    }

    public function setEntityManager($em)
    {
        $this->em = $em;
    }

    protected function configureShowFields(ShowMapper $showMapper)
    {
        $object = $this->getSubject();
        $showMapper
            ->add('fromCountry')
            ->add('toCountry')
            ->add('toCity')
            ->add('dateStart')
            ->add('dateEnd')
            ->add('addInfo')
        ;
        $room = $object->getRoom();
        if($room instanceof HotelRoom) {
            $showMapper
                ->add('room');
        }
        $apartment = $object->getApartment();
        if($apartment instanceof Apartment) {
            $showMapper
                ->add('apartment');
        }
        $showMapper
            ->add('services')
        ;

    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $object = $this->getSubject();
        $price = $object->getPrice();
        $prePayedPercent = 10;

        $addHomeType = new AddHomeFormType();
        $type = (is_null($object->getRoom())) ? 'apartment' : 'hotel';
        $addHomeType->setCity($object->getToCity());
        $addHomeType->setCurrType($type);
        $addHomeType->setLang($this->getLanguage());

        $isPayed = $object->getIsPayed();


        $formMapper
            ->with('admin.tour.left',['class' => 'col-md-6', 'translation_domain' => 'NetcastUrestMainBundle']);

        $formMapper
            ->add('fromCountry', 'text', [
                'label' => 'form.label.fromCountry',
                'read_only' => true
            ])
            ->add('toCountry', 'entity', [
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
                'label' => 'form.label.toCountry',
                'disabled' => true,
                'required' => false
            ])
            ->add('toCity', 'entity', [
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
                'disabled' => true,
                'required' => false
            ]);
            $room = $object->getRoom();
            if($room instanceof HotelRoom) {
                $hotel = $room->getHotel();
                $formMapper->add('hotel', 'entity', [
                    'class' => 'Netcast\Urest\MainBundle\Entity\Hotel',
                    'query_builder' => function($repository) {
                            return $repository->createQueryBuilder('c')
                                ->where('c.lang=:lang')
                                ->setParameter('lang',$this->getLanguage())
                                ->orderBy('c.id', 'ASC');
                        },
                    'property' => 'title',
                    'data' => $hotel,
                    'attr' => [
                        'class' => 'city_entity_field'
                    ],
                    'label' => 'form.label.hotel',
                    'disabled' => true,
                    'mapped' => false,
                    'required' => false
                ]);
                $formMapper->add('room', 'entity', [
                    'class' => 'Netcast\Urest\MainBundle\Entity\HotelRoom',
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
                    'label' => 'form.label.room',
                    'disabled' => true,
                    'required' => false
                ])
                ;
            }
            $apartment = $object->getApartment();
            if($apartment instanceof Apartment) {
                $formMapper->add('apartment', 'entity', [
                    'class' => 'Netcast\Urest\MainBundle\Entity\Apartment',
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
                    'label' => 'form.label.apartment',
                    'disabled' => true,
                    'required' => false
                ]);
            }
            $formMapper
            ->add('add_home', 'urest_collection', [
                'label' => 'form.label.add_home',
                'type' => $addHomeType,
                'options' => [
                    'data_class' => 'Netcast\Urest\MainBundle\Entity\AddTourHome',
                    'translation_domain' => 'NetcastUrestMainBundle',
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
            ->add('addInfo', 'textarea', [
                'label' => 'form.label.addInfo',
                'trim' => true,
                'disabled' => true,
                'required' => false,
            ])
            ->add('dateStart', 'sonata_type_date_picker', [
                'label' => 'form.label.dateStart',
                'format'=>'yyyy-MM-dd',
                'read_only' => true
            ])
            ->add('dateEnd', 'sonata_type_date_picker', [
                    'label' => 'form.label.dateEnd',
                    'format'=>'yyyy-MM-dd',
                    'read_only' => true
                ])
            ->add('author', 'entity', [
                'class' => 'Application\Sonata\UserBundle\Entity\User',
                'label' => 'form.label.author',
                'disabled' => true,
                'required' => false
            ]);
            if($isPayed) {
                $formMapper->add('pay_history', 'entity', [
                    'label' => 'form.label.pay_history',
                    'class' => 'Netcast\Urest\MainBundle\Entity\PayHistory',
                    'mapped' => false,
                    'disabled' => true,
                ]);
            } else {
                $formMapper->add('price', 'text', [
                    'label' => 'form.label.price',
                    'read_only' => true
                ]);
                $formMapper->add('prePay', 'text', [
                    'label' => 'form.label.prePay',
                    'data' => ($object->getPrePay()) ? $object->getPrePay() : (($price/100)*$prePayedPercent)
                ]);
            }

            $formMapper->end()
            ->with('admin.empty',['class' => 'clear', 'translation_domain' => 'NetcastUrestMainBundle'])
            ->add('clear','hidden',['mapped' => false])
            ->end()
            ->with('admin.tour.end',['class' => 'col-md-12', 'translation_domain' => 'NetcastUrestMainBundle'])
            ->add('services', 'urest_service_collection', [
                'label' => 'form.label.services',
                'type' => 'netcast_urest_tour_services_form',
                'options' => [
                    'data_class' => 'Netcast\Urest\MainBundle\Entity\CustomTourServices',
                    'translation_domain' => 'NetcastUrestMainBundle',
                    'label' => false,
                    'required' => false
                ],
                'attr' => ['class' => ''],
                'by_reference' => false,
                'allow_add' => true,
                'allow_delete' => false,
                'required' => false
            ])
            ->add('status', 'choice', array(
                'choices'  => [
                    0 => 'На модерации',
                    1 => 'На утверждение',
                    2 => 'На оплату',
                    4 => 'Оплаченные',
                ],
                'label' => 'form.label.status',
                'required' => true,
            ))
            ->end()
        ;
    }

    protected function isNewOrders()
    {
        return $this->isNewOrders;
    }

    public function createQuery($context = 'list') {

        $user = $this->getConfigurationPool()->getContainer()->get('security.context')->getToken()->getUser();
        $query = parent::createQuery($context);
        if($this->isNewOrders()) {
            $query
                ->andWhere($query->getRootAlias().'.moderator IS NULL')
            ;
            $managerCountry = $user->getManagerCountry();
            if($managerCountry) {
                $query->andWhere(
                    $query->expr()->eq($query->getRootAliases()[0] . '.toCountry', ':managerCountry')
                );
                $query->setParameter('managerCountry', $managerCountry->getId());
            }
        }
        return $query;
    }

    // Поля, отображаемые в списках
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id','text',['label' => 'form.label.number'])
            ->add('fromCountry', null, ['label' => 'form.label.fromCountry'])
            ->add('toCountry', null, ['label' => 'form.label.toCountry'])
            ->add('toCity', null, ['label' => 'admin.layout.city', 'template' => 'SonataMediaBundle:MediaAdmin:list_custom.html.twig'])
            ->add('dateStart', null, ['label' => 'form.label.dateStart'])
            ->add('dateEnd', null, ['label' => 'form.label.dateEnd'])
            ->add('author', null, ['label' => 'form.label.author', 'template' => 'SonataMediaBundle:MediaAdmin:list_custom.html.twig'])
            ->add('_action', 'actions', [
                'actions' => [
                    'view'   => []
                ]
            ])
        ;
    }
}
