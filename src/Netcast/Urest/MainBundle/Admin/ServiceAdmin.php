<?php

    namespace Netcast\Urest\MainBundle\Admin;

    use Netcast\Urest\MainBundle\Admin\BasicAdmin as Admin;
    use Sonata\AdminBundle\Datagrid\ListMapper;
    use Sonata\AdminBundle\Datagrid\DatagridMapper;
    use Sonata\AdminBundle\Form\FormMapper;
    use Symfony\Component\Validator\Constraints\NotBlank;


    class ServiceAdmin extends Admin
    {

        // перед созданием
        public function prePersist($item)
        {
            $type = $item->getType();
            if($type == 'option' || $type == 'day_option' || $item->getPrice() == null)
            {
                $item->setPrice(0);
            }
            $user = $this->getSecurityContext()->getToken()->getUser();
            $item->setUser($user);
            $item->setLang($this->getLanguage());
            $item->setCreated(new \DateTime());
            $item->setUpdated(new \DateTime());
            $this->toPositive($item);
        }

        // перед обновлением
        public function preUpdate($item)
        {
            $type = $item->getType();
            if($type == 'option')
            {
                $item->setPrice(0);
            }
            $this->toPositive($item);
            $item->setUpdated(new \DateTime());
        }



        // Поля, отображаемые в формах create/edit
        protected function configureFormFields(FormMapper $formMapper)
        {
            $service = $this->getSubject();
            $type = ($service->getId() === null)?'line':$service->getType();

            $city = $this->getSubject()->getCity();
            $region = (null === $city)?$city:$city->getRegion();
            $country = (null === $city)?$city:$city->getRegion()->getCountry();
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
                ->add('active', 'checkbox', [
                    'label' => 'form.label.active',
                    'required' => false,
                    'attr' => ['checked' => 'checked']
                ])
                ->end()
                ->with('admin.tour.right',['class' => 'col-md-6', 'translation_domain' => 'NetcastUrestMainBundle'])
                ->add('price', 'money', [
                    'label' => 'form.label.price',
                    'precision' => 2,
                    'invalid_message' => 'decimal_format',
                    'empty_data' => '0.00',
                    //'currency' => 'UAH',
                    'trim' => true,
                    'required' => false,
                    'attr' => [
                        'maxlength' => '25',
                        'data-format'=>'price'
                    ],
                ])
                ->add('type', 'choice', [
                    'label' => 'form.label.type',
                    'trim' => true,
                    'required' => true,
                    'choices'=>array('line'=>'Стоимость общая','day'=>'Стоимость по дням','option'=>'Стоимость по опциям','day_option'=>'Стоимость по опциям и по дням' ),
                    'expanded' => true,
                    'multiple' => false,
                    'data' => $type
                ])
                ->end()
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

        protected function configureListFields(ListMapper $listMapper)
        {
            $listMapper
                ->add('id','text',['label' => 'form.label.number'])
                ->add('title', null, ['label' => 'form.label.title'])
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

        protected function toPositive($item)
        {
            $price = $item->getPrice();
            if ($price<0)
                $item->setPrice(abs($price));
        }

    }