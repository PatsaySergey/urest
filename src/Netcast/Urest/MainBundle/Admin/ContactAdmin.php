<?php

namespace Netcast\Urest\MainBundle\Admin;

use Netcast\Urest\MainBundle\Admin\BasicAdmin as Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Validator\Constraints\NotBlank;

class ContactAdmin extends Admin
{
    // перед созданием
    public function prePersist($item)
    {
        $user = $this->getSecurityContext()->getToken()->getUser();
        $item->setUser($user);
        $item->setLang($this->getLanguage());
        $item->setCreated(new \DateTime());
        $item->setUpdated(new \DateTime());
    }

    // перед обновлением
    public function preUpdate($item)
    {
        $item->setUpdated(new \DateTime());
    }

    // Поля, отображаемые в формах create/edit
    protected function configureFormFields(FormMapper $formMapper)
    {
        $now     = new \DateTime();
        $city    = $this->getSubject()->getCity();
        $region  = (null === $city) ? $city : $city->getRegion();
        $country = (null === $city) ? $city : $city->getRegion()->getCountry();
        $formMapper
            ->with('admin.tour.left', ['class'              => 'col-md-6',
                'translation_domain' => 'NetcastUrestMainBundle'])
            ->add('country', 'entity', [
                'attr'          => array(
                    'data-sonata-select2' => 'false'),
                'attr'          => array(
                    'data-sonata-select2-allow-clear' => 'false'),
                'class'         => 'Netcast\Urest\MainBundle\Entity\Country',
                'query_builder' => function($repository) {
                return $repository->createQueryBuilder('c')
                    ->where('c.lang=:lang')
                    ->setParameter('lang', $this->getLanguage())
                    ->orderBy('c.title', 'ASC');
            },
                'property'    => 'title',
                'attr'        => [
                    'class' => 'country_entity_field'
                ],
                'data'        => $country,
                'empty_data'  => '',
                'empty_value' => '',
                'label'       => 'form.label.country',
                'required'    => true,
                'mapped'      => false,
            ])
            ->add('region', 'entity', [
                'class'         => 'Netcast\Urest\MainBundle\Entity\Region',
                'query_builder' => function($repository) {
                    return $repository->createQueryBuilder('r')
                        ->where('r.lang=:lang')
                        ->setParameter('lang', $this->getLanguage())
                        ->orderBy('r.title', 'ASC');
                },
                'property'    => 'title',
                'attr'        => [
                    'class' => 'region_entity_field'
                ],
                'label'       => 'form.label.region',
                'required'    => true,
                'empty_data'  => '',
                'empty_value' => '',
                'data'        => $region,
                'mapped'      => false,
            ])
            ->add('city', 'entity', [
                'class'         => 'Netcast\Urest\MainBundle\Entity\City',
                'query_builder' => function($repository) {
                    return $repository->createQueryBuilder('c')
                        ->where('c.lang=:lang')
                        ->setParameter('lang', $this->getLanguage())
                        ->orderBy('c.id', 'ASC');
                },
                'property'    => 'title',
                'attr'        => [
                    'class' => 'city_entity_field'
                ],
                'label'       => 'form.label.city',
                'empty_data'  => '',
                'empty_value' => '',
                'required'    => true
            ])
            ->add('icon', 'urest_media_type', [
                'label'              => 'form.label.icon',
                'provider'           => 'sonata.media.provider.image',
                'translation_domain' => 'NetcastUrestMainBundle',
                'required'           => false
            ])
            ->end()
            ->with('admin.tour.right', ['class'              => 'col-md-6',
                'translation_domain' => 'NetcastUrestMainBundle'])
            ->add('created', 'label_text', [
                'label'    => 'form.label.created',
                'trim'     => true,
                'required' => false,
                'data'     => ($this->getSubject()->getCreated() !== null) ? $this->getSubject()->getCreated() : $now,
                'mapped'   => false
            ])
            ->add('updated', 'label_text', [
                'label'    => 'form.label.updated',
                'trim'     => true,
                'required' => false,
                'data'     => ($this->getSubject()->getUpdated() !== null) ? $this->getSubject()->getUpdated() : $now,
                'mapped'   => false
            ])
            ->end()
            ->with('admin.empty', ['class'              => 'clear',
                'translation_domain' => 'NetcastUrestMainBundle'])
            ->add('clear', 'hidden', ['mapped' => false])
            ->end()
            ->with('admin.tour.end', ['class'              => 'col-md-12',
                'translation_domain' => 'NetcastUrestMainBundle'])
            ->add('description', 'ckeditor', [
                'label'       => 'form.label.description',
                'trim'        => true,
                'constraints' => [new NotBlank()],
                'required'    => true
            ])
            ->end()
            ->with('admin.contact.data', [
                'class'              => 'col-md-6',
                'translation_domain' => 'NetcastUrestMainBundle'])
            ->add('adress', 'textarea', [
                'label'    => 'form.label.adress',
                'trim'     => true,
                'required' => true,
            ])
            ->add('fax', 'text', [
                'label'    => 'form.label.fax',
                'trim'     => true,
                'required' => true,
            ])
            ->add('phone', 'text', [
                'label'    => 'form.label.phone',
                'trim'     => true,
                'required' => true,
            ])
            ->add('email', 'text', [
                'label'    => 'form.label.email',
                'trim'     => true,
                'required' => true,
            ])
            ->add('work_time', 'textarea', [
                'label'    => 'form.label.work_time',
                'trim'     => true,
                'required' => true,
            ])
            ->end()
        ;
    }

    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);
        $query
            ->andWhere($query->getRootAlias() . '.lang = :lang')
            ->setParameter('lang', $this->getLanguage())
        ;

        return $query;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id', 'text', ['label' => 'form.label.number'])
            ->add('country', 'string', ['label'    => 'form.label.country',
                'template' => 'NetcastUrestMainBundle:CRUD:list_country.html.twig'])
            ->add('city', 'string', ['label' => 'form.label.city'])
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