<?php

namespace Netcast\Urest\MainBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Security\Core\SecurityContext;

/**
 * Description of TourDatesFormType
 *
 * @author kvk
 */
class TourDatesFormType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
            $builder
                ->add('date_from', 'sonata_type_date_picker', [
                    'label' => 'form.label.date_start',
                    'trim' => true,
                    'widget' => 'single_text',
                    'format' => 'yyyy-MM-dd',
                    'model_timezone'=>'Europe/Kiev',
                    'view_timezone'=>'Europe/Kiev',
                    'constraints' => [new NotBlank()],
                    'translation_domain' => 'NetcastUrestMainBundle'
                ])
                ->add('date_to', 'sonata_type_date_picker', [
                    'label' => 'form.label.date_end',
                    'trim' => true,
                    'model_timezone'=>'Europe/Kiev',
                    'view_timezone'=>'Europe/Kiev',
                    'widget' => 'single_text',
                    'format' => 'yyyy-MM-dd',
                    'constraints' => [new NotBlank()],
                    'translation_domain' => 'NetcastUrestMainBundle'
                ])
                ->add('price', 'money', [
                    'label' => 'form.label.price',
                    'currency' => false,
                    'trim' => true,
                    'constraints' => [new NotBlank()],
                    'translation_domain' => 'NetcastUrestMainBundle',
                    'attr' => [
                        'maxlength' => '25',
                        'data-format'=>'price'
                    ],
                ])
        ;
    }

    public function getName() {
        return 'netcast_urest_tour_dates_form';
    }
}