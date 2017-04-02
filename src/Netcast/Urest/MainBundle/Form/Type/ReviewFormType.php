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
    class ReviewFormType extends AbstractType {

        public function buildForm(FormBuilderInterface $builder, array $options)
        {
            $builder->addEventListener(FormEvents::SUBMIT, array($this, 'onSubmit'));
            $builder
                ->add('review', 'textarea', [
                    'label' => 'form.label.review',
                    'constraints' => [new NotBlank()],
                    'translation_domain' => 'NetcastUrestMainBundle',
                    'required' => true
                ])
                ->add('captcha', 'captcha',array(
                    'width' => 100,
                    'height' => 31
                ))
            ;
        }

        public function onSubmit(FormEvent $event) {

            $data = $event->getData();

            $data->setCreated(new \DateTime());
            $data->setUpdated(new \DateTime());
            $data->setOnMain(false);
            $data->setNew(true);
        }

        public function getName() {
            return 'netcast_urest_review_form_type';
        }
    }