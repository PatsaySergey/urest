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
class AddHomeFormType extends AbstractType {

    private $lang;
    private $city;
    private $type;

    public function setCity($city)
    {
        $this->city = $city;
    }

    public function setCurrType($type)
    {
        $this->type = $type;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', 'choice', [
                'label' => 'form.label.type',
                'choices' => [
                    'apartment' => 'Апартаменты',
                    'hotel' => 'Отель'
                ],
                'attr' => [
                    'class' => 'jsAddTypeSelect'
                ],
                'translation_domain' => 'NetcastUrestMainBundle',
                'multiple' => false,
                'expanded' => true,
                'required' => true,
            ])
            ->add('hotel', 'entity', [
                'class' => 'Netcast\Urest\MainBundle\Entity\Hotel',
                'query_builder' => function($repository) {
                        return $repository->createQueryBuilder('c')
                            ->where('c.lang=:lang')
                            ->andWhere('c.city=:city')
                            ->setParameter('lang',$this->lang)
                            ->setParameter('city',$this->city)
                            ->orderBy('c.id', 'ASC');
                    },
                'property' => 'title',
                'attr' => [
                    'class' => ($this->type == 'hotel') ? 'jsAddHotelSelect' : 'jsAddHotelSelect hide'
                ],
                'label_attr' => [
                    'class' => ($this->type == 'hotel') ? 'jsAddHotelLabel' : 'jsAddHotelLabel hide'
                ],
                'empty_data' => null,
                'empty_value' => 'Выбрать',
                'label' => 'form.label.hotel',
                'mapped' => false
            ])
            ->add('room', 'entity', [
                'class' => 'Netcast\Urest\MainBundle\Entity\HotelRoom',
                'query_builder' => function($repository) {
                        return $repository->createQueryBuilder('c')
                            ->where('c.lang=:lang')
                            ->setParameter('lang',$this->lang)
                            ->orderBy('c.id', 'ASC');
                    },
                'property' => 'title',
                'attr' => [
                    'class' => ($this->type == 'hotel') ? 'jsAddRoomSelect' : 'jsAddRoomSelect hide'
                ],
                'label_attr' => [
                    'class' => ($this->type == 'hotel') ? 'jsAddRoomLabel' : 'jsAddRoomLabel hide'
                ],
                'empty_data' => null,
                'empty_value' => 'Выбрать',
                'label' => 'form.label.room',
            ])
            ->add('apartment', 'entity', [
                'class' => 'Netcast\Urest\MainBundle\Entity\Apartment',
                'query_builder' => function($repository) {
                        return $repository->createQueryBuilder('c')
                            ->where('c.lang=:lang')
                            ->andWhere('c.city=:city')
                            ->setParameter('lang',$this->lang)
                            ->setParameter('city',$this->city)
                            ->orderBy('c.id', 'ASC');
                    },
                'property' => 'title',
                'attr' => [
                    'class' => ($this->type == 'hotel') ? 'jsAddApartmentSelect hide' : 'jsAddApartmentSelect'
                ],
                'label_attr' => [
                    'class' => ($this->type == 'hotel') ? 'jsAddApartmentLabel hide' : 'jsAddApartmentLabel'
                ],
                'label' => 'form.label.apartment'
            ]);

    }

    public function setLang($lang)
    {
        $this->lang = $lang;
    }

    public function getName() {
        return 'netcast_urest_add_home_form';
    }
}