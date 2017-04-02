<?php

    namespace Netcast\Urest\MainBundle\Admin;

    use Netcast\Urest\MainBundle\Admin\BasicAdmin as Admin;
    use Sonata\AdminBundle\Datagrid\ListMapper;
    use Sonata\AdminBundle\Datagrid\DatagridMapper;
    use Sonata\AdminBundle\Form\FormMapper;
    use Symfony\Component\Validator\Constraints\NotBlank;


    class OptionsAdmin extends Admin
    {

        // перед созданием
        public function prePersist($item)
        {
            $user = $this->getSecurityContext()->getToken()->getUser();
            $item->setUser($user);
            $item->setLang($this->getLanguage());
            $item->setCreated(new \DateTime());
            $item->setUpdated(new \DateTime());
            $this->toPositive($item);
            foreach($item->getImages() as $img) {
                if($img->getMedia() !== null)
                    $img->setOption($item);
                else
                    $item->removeImage($img);
            }
        }

        // перед обновлением
        public function preUpdate($item)
        {
            $item->setUpdated(new \DateTime());
            $this->toPositive($item);
            foreach($item->getImages() as $img) {
                if($img->getMedia() !== null)
                    $img->setOption($item);
                else
                    $item->removeImage($img);
            }

        }

        // Поля, отображаемые в формах create/edit
        protected function configureFormFields(FormMapper $formMapper)
        {
            $parentService = $this->getParentEntity('Netcast\Urest\MainBundle\Entity\Service');

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
                ->add('price', 'money', [
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
                ->with('admin.tour.right',['class' => 'col-md-6', 'translation_domain' => 'NetcastUrestMainBundle']);
                if ($parentService != null)
                {
                    $formMapper->add('service', 'entity', [
                        'class' => 'Netcast\Urest\MainBundle\Entity\Service',
                        'query_builder' => function($repository) {
                                return $repository->createQueryBuilder('r')
                                    ->where('r.lang=:lang')
                                    ->setParameter('lang',$this->getLanguage())
                                    ->andWhere('r.type=:type OR r.type=:type2')
                                    ->setParameter('type','option')
                                    ->setParameter('type2','day_option')
                                    ->orderBy('r.id', 'ASC');
                            },
                        'data' =>  $parentService,
                        'property' => 'title',
                        'label' => 'form.label.service',
                        'required' => false,
                    ]);
                }
                else
                {
                    $formMapper->add('service', 'entity', [
                        'class' => 'Netcast\Urest\MainBundle\Entity\Service',
                        'query_builder' => function($repository) {
                                return $repository->createQueryBuilder('r')
                                    ->where('r.lang=:lang')
                                    ->setParameter('lang',$this->getLanguage())
                                    ->andWhere('r.type=:type OR r.type=:type2')
                                    ->setParameter('type','option')
                                    ->setParameter('type2','day_option')
                                    ->orderBy('r.id', 'ASC');
                            },
                        'property' => 'title',
                        'label' => 'form.label.service',
                        'required' => false,
                    ]);
                }
            $formMapper->end()
                ->with('admin.empty',['class' => 'clear', 'translation_domain' => 'NetcastUrestMainBundle'])
                ->add('clear','hidden',['mapped' => false])
                ->end()
                ->with('admin.tour.end',['class' => 'col-md-12', 'translation_domain' => 'NetcastUrestMainBundle'])
                ->add('description', 'ckeditor', [
                    'label' => 'form.label.description',
                    'trim' => true,
                    'constraints' => [new NotBlank()],
                    'required' => true
                ])
                ->add('images', 'urest_collection', [
                    'label' => 'form.label.images',
                    'type' => 'netcast_urest_media_collection_form',
                    'options' => [
                        'label' => false,
                        'required' => false,
                        'data_class' => 'Netcast\Urest\MainBundle\Entity\OptionImages',
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
                ->andWhere($query->getRootAlias().'.service = :service')
                ->setParameter('service', $parent->getId())
            ;
            return $query;
        }

        public function createQuery($context = 'list') {
            $query = parent::createQuery($context);
            $query
                ->andWhere($query->getRootAlias().'.lang = :lang')
                ->setParameter('lang', $this->getLanguage())
            ;

            return $query;
        }

        protected function configureListFields(ListMapper $listMapper)
        {
            $listMapper
                ->add('id','text',['label' => 'form.label.number'])
                ->add('title', null, ['label' => 'form.label.title'])
                ->add('price', null, ['label' => 'form.label.price'])

                ->add('service','string',['label'=>'form.label.service', 'template' => 'SonataMediaBundle:MediaAdmin:list_custom.html.twig'])

                ->add('created', null, ['label' => 'form.label.created'])
                ->add('_action', 'actions', [
                    'actions' => [
                        'edit'   => ['template' => 'NetcastUrestMainBundle:CRUD:list__action_edit.html.twig'],
                        'delete' => ['template' => 'NetcastUrestMainBundle:CRUD:list__action_delete.html.twig'],
                    ]
                ])
            ;
        }

        protected function toPositive($item)
        {
            $price = $item->getPrice();
            if ($price<0)
                $item->setPrice(abs($price));
        }

    }