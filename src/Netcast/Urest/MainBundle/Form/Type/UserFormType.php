<?php

namespace Netcast\Urest\MainBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;

/**
 * Description of TourDatesFormType
 *
 * @author kvk
 */
class UserFormType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventListener(FormEvents::SUBMIT, array($this, 'onSubmit'));
        $builder
            ->add('firstname', 'text', [
                'label' => 'form.label.firstname',
                'attr' => ['class' => 'form-control'],
                'constraints' => [new NotBlank()],
                'translation_domain' => 'NetcastUrestMainBundle',
                'required' => true
            ])
            ->add('lastname', 'text', [
                'label' => 'form.label.lastname',
                'attr' => ['class' => 'form-control'],
                'constraints' => [new NotBlank()],
                'translation_domain' => 'NetcastUrestMainBundle',
                'required' => true
            ])
            ->add('avatar', 'urest_user_media_type', [
                'label' => 'form.label.avatar',
                'provider' => 'sonata.media.provider.image',
                'translation_domain' => 'NetcastUrestMainBundle',
                'required' => false
            ])
            ->add('gender', 'urest_gender', [
                'label' => 'form.label.gender',
                'choices' => [
                  'm' => 'Male',
                  'f' => 'Female'
                ],
                'translation_domain' => 'NetcastUrestMainBundle',
                'multiple' => false,
                'expanded' => true,
                'required' => true,
            ])
            ->add('email', 'email', [
                'label' => 'form.label.email',
                'attr' => ['class' => 'form-control'],
                'constraints' => [new NotBlank()],
                'translation_domain' => 'NetcastUrestMainBundle',
                'required' => true
            ])
            ->add('dateOfBirth', 'date', [
                'label' => 'form.label.dateOfBirth',
                'attr' => ['class' => ''],
                'years' => range(date('Y'),date('Y')-100),
                'translation_domain' => 'NetcastUrestMainBundle',
                'required' => true
            ])
            ->add('country', 'text', [
                'label' => 'form.label.country',
                'attr' => ['class' => 'form-control'],
                'constraints' => [new NotBlank()],
                'translation_domain' => 'NetcastUrestMainBundle',
                'required' => true
            ])
            ->add('city', 'text', [
                'label' => 'form.label.city',
                'attr' => ['class' => 'form-control'],
                'constraints' => [new NotBlank()],
                'translation_domain' => 'NetcastUrestMainBundle',
                'required' => true
            ])

        ;
    }

    public function onSubmit(FormEvent $event) {
        $data = $event->getData();
        //$data->getAvatar()->setName('dvsdvsdv');
        //$data->setCreated(new \DateTime());
    }

    public function getName() {
        return 'netcast_urest_user_form_type';
    }
}