<?php

namespace Netcast\Urest\MainBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Sonata\UserBundle\Form\Type\RegistrationFormType as BaseType;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Doctrine\ORM\EntityManager;

class RegistrationFormType extends BaseType
{
    /**
     * Entity Manager
     * @var EntityManager
     */
    protected $em;

    /**
     * User group class
     * @var string
     */
    protected $groupClass;

    public function __construct(EntityManager $em, $group_class, $class)
    {
        $this->em          = $em;
        $this->groupClass = $group_class;

        parent::__construct($class);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->addEventListener(FormEvents::SUBMIT, array($this, 'onSubmit'))
            ->setAction('netcast_urest_register')
            ->add('first_name', null, array(
                'label'              => 'registration.form.label.username',
                'label_attr'         => array(
                    'class' => 'title',
                ),
                'translation_domain' => 'NetcastUrestMainBundle',
                'attr'               => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('gender', 'choice', array(
                'label'              => 'registration.form.label.gender',
                'translation_domain' => 'NetcastUrestMainBundle',
                'label_attr'         => array(
                    'class' => 'title',
                ),
                'choices'            => array(
                    'm'   => 'Male',
                    'f' => 'Female',
                ),
                'expanded'           => true,
            ))
            ->add('dateOfBirth', 'date', array(
                'label'              => 'form.label_date_of_birth',
                'format'             => \IntlDateFormatter::LONG,
                'years'              => range(date('Y'), date('Y') - 100),
                'label_attr'         => array(
                    'class' => 'title',
                ),
                'translation_domain' => 'SonataUserBundle',
                'empty_value'        => array('1', '2', '3',),
                'empty_data'         => null,
            ))
            ->add('email', 'email', array(
                'label'              => 'registration.form.label.email',
                'label_attr'         => array(
                    'class' => 'title',
                ),
                'translation_domain' => 'NetcastUrestMainBundle',
                'attr'               => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('plainPassword', 'repeated', array(
                'type'            => 'password',
                'options'         => array(
                    'translation_domain' => 'NetcastUrestMainBundle',
                ),
                'first_options'   => array(
                    'label'      => 'registration.form.label.password',
                    'label_attr' => array(
                        'class' => 'title',
                    ),
                    'attr'       => array(
                        'class' => 'form-control',
                    )
                ),
                'second_options'  => array(
                    'label'      => 'registration.form.label.password_repeat',
                    'label_attr' => array(
                        'class' => 'title',
                    ),
                    'attr'       => array(
                        'class' => 'form-control',
                    )
                ),
                'invalid_message' => 'registration.messages.password.mismatch',
            ))
        ;
    }

    public function getName()
    {
        return 'netcast_urest_user_registration';
    }

    public function onSubmit(FormEvent $event)
    {
        $data = $event->getData();
        $data->setUsername($data->getEmail());

        // add default user group
        $group = $this->em->getRepository($this->groupClass)
            ->findOneByName('Зарегистрированный пользователь');

        if ($group) {
            $data->addGroup($group);
        }
    }
}