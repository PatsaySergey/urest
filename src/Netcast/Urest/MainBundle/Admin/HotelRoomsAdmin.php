<?php

    namespace Netcast\Urest\MainBundle\Admin;

    use Netcast\Urest\MainBundle\Admin\BasicAdmin as Admin;
    use Sonata\AdminBundle\Datagrid\ListMapper;
    use Sonata\AdminBundle\Datagrid\DatagridMapper;
    use Sonata\AdminBundle\Form\FormMapper;
    use Symfony\Component\Validator\Constraints\NotBlank;

    class HotelRoomsAdmin extends Admin
    {

        // перед созданием
        public function prePersist($item)
        {
            $user = $this->getSecurityContext()->getToken()->getUser();
            $item->setUser($user);

            $item->setLang($this->getLanguage());
            $item->setCreated(new \DateTime());
            $item->setUpdated(new \DateTime());
            foreach($item->getImages() as $itemImages) {
                if($itemImages->getMedia() !== null)
                    $itemImages->setRoom($item);
                else
                    $item->removeImage($itemImages);
            }
            foreach($item->getRoomContent() as $roomContent) {
                if(!$roomContent->getIsDeleted())
                    $roomContent->setParent($item);
                else
                    $item->removeCityContent($roomContent);
            }
        }

        // перед обновлением
        public function preUpdate($item)
        {

            $item->setUpdated(new \DateTime());
            foreach($item->getImages() as $itemImages) {
                if($itemImages->getMedia() !== null)
                    $itemImages->setRoom($item);
                else
                    $item->removeImage($itemImages);
            }
            foreach($item->getRoomContent() as $roomContent) {
                if(!$roomContent->getIsDeleted())
                    $roomContent->setParent($item);
                else
                    $item->removeCityContent($roomContent);
            }
        }



        // Поля, отображаемые в формах create/edit
        protected function configureFormFields(FormMapper $formMapper)
        {
            $parentHotel = $this->getParentEntity('Netcast\Urest\MainBundle\Entity\Hotel');
            $formMapper
                ->with('admin.tour.left',['class' => 'col-md-6', 'translation_domain' => 'NetcastUrestMainBundle']);
            $formMapper->add('hotel', 'entity', [
                'class' => 'Netcast\Urest\MainBundle\Entity\Hotel',
                'data' =>  $parentHotel,
                'property' => 'content',
                'label' => 'form.label.hotel',
                'required' => true,
            ]);
            $formMapper
                ->end()
                ->with('admin.tour.right',['class' => 'col-md-6', 'translation_domain' => 'NetcastUrestMainBundle'])
                    ->add('price', 'money', [
                        'label' => 'form.label.price',
                        'precision' => 2,
                        'invalid_message' => 'decimal_format',
                        'empty_data' => '0.00',
                        'trim' => true,
                        'required' => true,
                        'attr' => [
                            'maxlength' => '25',
                            'data-format'=>'price'
                        ],
                    ]);
                $formMapper
                    ->end()
                    ->with('admin.empty',['class' => 'clear', 'translation_domain' => 'NetcastUrestMainBundle'])
                    ->add('clear','hidden',['mapped' => false])
                    ->end()
                    ->with('admin.tour.end',['class' => 'col-md-12', 'translation_domain' => 'NetcastUrestMainBundle'])
                    ->add('roomContent', 'urest_i18n_collection', [
                        'label' => 'form.label.content',
                        'type' => 'netcast_urest_title_content_form',
                        'options' => [
                            'label' => false,
                            'required' => false,
                            'data_class' => 'Netcast\Urest\MainBundle\Entity\HotelRoomContent',
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
                        'data_class' => 'Netcast\Urest\MainBundle\Entity\RoomImages',
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
                    ->end()
            ;
        }


        public function createChildrenQuery($query,$parent)
        {
            $query
                ->andWhere($query->getRootAlias().'.hotel = :hotel')
                ->setParameter('hotel', $parent->getId())
            ;
            return $query;
        }

        protected function configureListFields(ListMapper $listMapper)
        {
            $listMapper
                ->add('id','text',['label' => 'form.label.number'])
                ->add('content', null, ['label' => 'form.label.title'])
                ->add('hotel','string',['label'=>'form.label.hotel', 'template' => 'SonataMediaBundle:MediaAdmin:list_custom.html.twig'])
                ->add('price','string',['label'=>'form.label.price'])
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