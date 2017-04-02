<?php

namespace Netcast\Urest\MainBundle\Form\Type;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;

/**
 * Description of PostType
 *
 * @author melk
 */
class TourOrderFormType extends AbstractType
{
    private $lang;

    public function __construct($lang) {
        $this->lang = $lang;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $lang = $this->lang;
        $builder->addEventListener(FormEvents::SUBMIT, [$this, 'setCurrentOption']);
        $builder
                ->add('fromCountry', 'entity', [
                    'attr' => ['class' => 'form-control'],
                    'class' => 'Netcast\Urest\MainBundle\Entity\Country',
                    'query_builder' => function(EntityRepository $er) use ($lang) {
                            return $er->createQueryBuilder('c')
                                ->andWhere('c.lang = :lang')
                                ->setParameter('lang', $lang)
                                ->orderBy('c.title', 'ASC');
                        },
                    'empty_value' => '',
                    'empty_data' => null,
                    'label' => 'customTour.form.fromCountry',
                    'translation_domain' => 'NetcastUrestMainBundle'
                ])
            ->add('toCountry', 'entity', [
                'attr' => ['class' => 'form-control jsTourCountrySelect'],
                'class' => 'Netcast\Urest\MainBundle\Entity\Country',
                'query_builder' => function(EntityRepository $er) use ($lang) {
                        return $er->createQueryBuilder('c')
                            ->andWhere('c.lang = :lang')
                            ->setParameter('lang', $lang)
                            ->orderBy('c.title', 'ASC');
                    },
                'empty_value' => '',
                'empty_data' => null,
                'label' => 'customTour.form.toCountry',
                'translation_domain' => 'NetcastUrestMainBundle'
            ])
            ->add('toCity', 'choice', [
                'attr' => ['class' => 'form-control jsCitySelector'],
                'empty_value' => '',
                'choices' => [],
                'empty_data' => null,
                'label' => 'customTour.form.toCity',
                'mapped' => false,
                'translation_domain' => 'NetcastUrestMainBundle'
            ])
            ->add('dateStart', 'text', [
                'label' => 'customTour.form.dateStart',
                'attr' => ['class' => 'form-control'],
                'translation_domain' => 'NetcastUrestMainBundle'
            ])
            ->add('dateEnd', 'text', [
                'label' => 'customTour.form.dateEnd',
                'attr' => ['class' => 'form-control'],
                'translation_domain' => 'NetcastUrestMainBundle'
            ])
            ->add('room', 'entity', [
                'attr' => ['class' => 'form-control jsRoomSelect'],
                'class' => 'Netcast\Urest\MainBundle\Entity\HotelRoom',
                'query_builder' => function(EntityRepository $er) use ($lang) {
                        return $er->createQueryBuilder('c')
                            ->andWhere('c.lang = :lang')
                            ->setParameter('lang', $lang)
                            ->orderBy('c.title', 'ASC');
                    },
                'empty_value' => '',
                'empty_data' => null,
                'label' => 'customTour.form.toCity',
                'translation_domain' => 'NetcastUrestMainBundle'
            ])
            ->add('apartment', 'entity', [
                'attr' => ['class' => 'form-control'],
                'class' => 'Netcast\Urest\MainBundle\Entity\Apartment',
                'query_builder' => function(EntityRepository $er) use ($lang) {
                        return $er->createQueryBuilder('c')
                            ->andWhere('c.lang = :lang')
                            ->setParameter('lang', $lang)
                            ->orderBy('c.title', 'ASC');
                    },
                'empty_value' => '',
                'empty_data' => null,
                'label' => 'customTour.form.apartment',
                'translation_domain' => 'NetcastUrestMainBundle'
            ]);

    }

    /**
     * On submit event. Used to set post author and add post to all proper feeds
     * @param \Symfony\Component\Form\FormEvent $event
     */
    public function setCurrentOption(FormEvent $event){
        $data = $event->getData();
        $dateStart = $data->getDateStart();
        $dateEnd = $data->getDateEnd();
        $data->setDateStart(new \DateTime($dateStart));
        $data->setDateEnd(new \DateTime($dateEnd));
        $data->setLang($this->lang);
        $data->setAddInfo('dsvsdvsd');
    }


    public function getName() {
        return 'netcast_urest_tour_order';
    }

}

?>
