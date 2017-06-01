<?php

namespace Netcast\Urest\MainBundle\Admin;

use Netcast\Urest\MainBundle\Admin\BasicAdmin as Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class CityAdmin extends Admin
{

    // перед созданием
    public function prePersist($item)
    {
        $user = $this->getSecurityContext()->getToken()->getUser();
        $item->setUser($user);
        $item->setCreated(new \DateTime());
        $item->setUpdated(new \DateTime());
        foreach($item->getCityContent() as $cityContent) {
            if(!$cityContent->getIsDeleted())
                $cityContent->setParent($item);
            else
                $item->removeCityContent($cityContent);
        }
    }

    // перед обновлением
    public function preUpdate($item)
    {
        $item->setUpdated(new \DateTime());
        foreach($item->getCityContent() as $cityContent) {
            if(!$cityContent->getIsDeleted())
                $cityContent->setParent($item);
            else
                $item->removeCityContent($cityContent);
        }
    }

    // Поля, отображаемые в формах create/edit
    protected function configureFormFields(FormMapper $formMapper)
    {
        $parentRegion = $this->getParentEntity('Netcast\Urest\MainBundle\Entity\Region');

        $formMapper
            ->with('admin.tour.left',['class' => 'col-md-6', 'translation_domain' => 'NetcastUrestMainBundle'])
            ->add('cityContent', 'urest_i18n_collection', [
                'label' => 'form.label.content',
                'type' => 'netcast_urest_title_one_content_form',
                'options' => [
                    'label' => false,
                    'required' => false,
                    'data_class' => 'Netcast\Urest\MainBundle\Entity\CityContent',
                ],
                'by_reference' => false,
                'allow_add' => true,
                'allow_delete' => false,
                'required' => false
            ]);
        if($parentRegion !== null)
        {
            $country = $parentRegion->getCountry();
            $formMapper->add('region', 'entity', [
                'class' => 'Netcast\Urest\MainBundle\Entity\Region',
                'query_builder' => function($repository) use ($country){
                        return $repository->createQueryBuilder('r')
                            ->andWhere('r.country = :country')
                            ->setParameter('country',$country->getId())
                            ->orderBy('r.id', 'ASC');
                    },
                'property' => 'title',
                'attr' => ['class' => 'region_entity_field'],
                'label' => 'form.label.region',
                'data' => $parentRegion,
                'required' => true,
            ]);
        }
        else
        {
            $formMapper
                ->add('region', 'entity', [
                    'class' => 'Netcast\Urest\MainBundle\Entity\Region',
                    'query_builder' => function($repository) {
                            return $repository->createQueryBuilder('r')
                                ->where('r.lang=:lang')
                                ->setParameter('lang',$this->getLanguage())
                                ->orderBy('r.id', 'ASC');
                        },
                    'property' => 'title',
                    'attr' => ['class' => 'region_entity_field'],
                    'label' => 'form.label.region',
                    'required' => true,
                ]);
        }
        $formMapper
            ->add('coordinates', 'text', [
                'label' => 'form.label.coordinates',
                'trim' => true,
                'required' => true
            ])
            ->end()
        ;
    }

    public function createChildrenQuery($query,$parent)
    {
        $query
            ->andWhere($query->getRootAlias().'.region = :region')
            ->setParameter('region', $parent->getId())
        ;
        return $query;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id','text',['label' => 'form.label.number'])
            ->add('content', null, ['label' => 'form.label.title'])
            ->add('coordinates', null, ['label' => 'form.label.coordinates'])
            ->add('region','string',['label'=>'form.label.region'])
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