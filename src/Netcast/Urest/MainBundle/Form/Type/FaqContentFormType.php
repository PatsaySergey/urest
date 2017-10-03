<?php
/**
 * Created by PhpStorm.
 * User: Patsay Sergey
 * Date: 02.10.2017
 * Time: 21:07
 */

namespace Netcast\Urest\MainBundle\Form\Type;


use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Validator\Constraints\NotBlank;

class FaqContentFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('isDeleted','hidden')
            ->add('lang','entity', [
                'class' => 'Netcast\Urest\MainBundle\Entity\Language',
                'query_builder' => function($repository) {
                    return $repository->createQueryBuilder('l')
                        ->where('l.display=:display')
                        ->setParameter('display',1)
                        ->orderBy('l.title', 'ASC');
                },
                'attr' => [
                    'style' => 'display:none',
                ],
                'property' => 'title',
                'label' => false,
                'empty_data' => '',
                'empty_value' => '',
                'required' => true
            ])
            ->add('question', 'textarea', [
                'translation_domain' => 'NetcastUrestMainBundle',
                'label' => 'form.label.question',
                'attr' => array('rows' => 10)
            ])
            ->add('answer', 'textarea', [
                'translation_domain' => 'NetcastUrestMainBundle',
                'label' => 'form.label.answer',
                'attr' => array('rows' => 10)
            ])
        ;
    }

    public function getName() {
        return 'netcast_urest_faq_content_form';
    }

}