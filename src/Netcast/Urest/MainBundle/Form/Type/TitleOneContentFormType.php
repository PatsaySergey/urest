<?php
/**
 * Created by PhpStorm.
 * User: Patsay Sergey
 * Date: 22.05.2017
 * Time: 22:10
 */

namespace Netcast\Urest\MainBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;

class TitleOneContentFormType extends AbstractType
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
            ->add('title', 'text', [
                'label' => 'form.label.title',
                'trim' => true,
                'required' => true,
                'translation_domain' => 'NetcastUrestMainBundle',
                'attr' => [
                    'maxlength' => '255',
                ],
            ])
        ;
    }

    public function getName() {
        return 'netcast_urest_title_one_content_form';
    }
}

