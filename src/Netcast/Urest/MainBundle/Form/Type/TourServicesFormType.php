<?php

namespace Netcast\Urest\MainBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Security\Core\SecurityContext;

/**
 * Description of TourDatesFormType
 *
 * @author kvk
 */
class TourServicesFormType extends AbstractType {

    private $lang;

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('service', 'entity', [
                'class' => 'Netcast\Urest\MainBundle\Entity\Service',
                'query_builder' => function($repository) {
                        return $repository->createQueryBuilder('c')
                            ->where('c.lang=:lang')
                            ->setParameter('lang',$this->lang)
                            ->orderBy('c.id', 'ASC');
                    },
                'property' => 'title',
                'attr' => [
                    'class' => 'tourServiceSelect',
                    'style' => 'max-width: 200px;'
                ],
                'label' => 'form.label.service',
                'empty_value' => '',
                'empty_data' => '',
                'required' => true
            ]);
        $builder
            ->add('option', 'entity', [
                'class' => 'Netcast\Urest\MainBundle\Entity\Options',
                'query_builder' => function($repository) {
                        return $repository->createQueryBuilder('c')
                            ->where('c.lang=:lang')
                            ->setParameter('lang',$this->lang)
                            ->orderBy('c.id', 'ASC');
                    },
                'property' => 'title',
                'attr' => [
                    'style' => 'max-width: 200px',
                    'class' => 'tourOptionSelect',
                    'required' => false
                ],
                'label' => 'form.label.options',
                'required' => false
            ])
            ->add('dateStart', 'urest_type_date_picker', [
                'label' => 'form.label.dateStart',
                'format' => 'dd-MM-yyyy',
                'trim' => true,
                'required' => false
            ])
            ->add('dateEnd', 'urest_type_date_picker', [
                'label' => 'form.label.dateEnd',
                'format' => 'dd-MM-yyyy',
                'trim' => true,
                'required' => false
            ])
            ->add('isCancel', 'checkbox', array(
                'label'    => 'form.label.isCancel',
                'required' => false,
            ))
            ->add('userApprove', 'checkbox', array(
                'label'    => 'form.label.userApprove',
                'required' => false,
                'disabled' => true
            ))

        ;
    }

    public function setLang($lang)
    {
        $this->lang = $lang;
    }

    public function getName() {
        return 'netcast_urest_tour_services_form';
    }
}