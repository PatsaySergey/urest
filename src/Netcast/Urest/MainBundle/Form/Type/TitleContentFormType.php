<?php
/**
 * Created by PhpStorm.
 * User: Patsay Sergey
 * Date: 01.06.2017
 * Time: 19:47
 */

namespace Netcast\Urest\MainBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Validator\Constraints\NotBlank;

class TitleContentFormType extends AbstractType
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
            ->add('content', 'ckeditor', [
                'translation_domain' => 'NetcastUrestMainBundle',
                'label' => 'form.label.description',
                'attr' => array('class' => 'ckeditor', 'rows' => 20),
                'constraints' => [new NotBlank()],
                'config_name' => 'admin_config'
            ])
        ;
    }

    public function getName() {
        return 'netcast_urest_title_content_form';
    }
}