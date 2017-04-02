<?php

namespace Netcast\Urest\MainBundle\Admin;

use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class MyCustomTourAdmin extends CustomTourAdmin
{
    protected $isNewOrders = false;

    private $price = 0;
    private $daysCount = 0;

    /**
     * Remove "create" routes and add accept/decline routes
     * @param \Sonata\AdminBundle\Route\RouteCollection $collection
     */
    public function configureRoutes(RouteCollection $collection) {
        parent::configureRoutes($collection);
        $collection
            ->remove('take')
            ->remove('create');
    }

    public function preUpdate($tour)
    {
        $this->setDaysCount($tour);
        $this->setBatPrice($tour);
        if($tour->getStatus() == 2) {
            $tour->setPayTo(new \DateTime('+7 day'));
        }
        foreach($tour->getServices() as $tourService) {
            if($tourService->getId() == null) {
                $tourService->setUserApprove(false);
                $tourService->setIsModerated(true);
                $tourService->setIsCancel(false);
            }
            $serviceType = $tourService->getService()->getType();
            if($serviceType == 'day' || $serviceType == 'day_option') {
                if(is_null($tourService->getDateStart())) {
                    $tourService->setDateStart($tour->getDateStart());
                }
                if(is_null($tourService->getDateEnd())) {
                    $tourService->setDateEnd($tour->getDateEnd());
                }
            }
            $this->addServicePrice($tourService,$serviceType);
            $tourService->setTour($tour);
        }
        $tour->setPrice($this->price);
        foreach($tour->getAddHome() as $addHome) {
            $addHome->setTour($tour);
        }

        if($tour->getStatus() == 1) {
            $this->getConfigurationPool()->getContainer()->get('netcast.urest.mailer')->sendConfirmTourMail($tour->getId());
        }

    }

    private function addServicePrice($tourService,$serviceType)
    {
        switch($serviceType) {
            case 'line':
                $this->price += $tourService->getService()->getPrice();
                break;
            case 'day':
                $dateStart = $tourService->getDateStart();
                $dateEnd = $tourService->getDateEnd();
                $daysCount = $dateEnd->diff($dateStart)->format("%a");
                $this->price += $tourService->getService()->getPrice()*$daysCount;
                break;
            case 'day_option':
                $dateStart = $tourService->getDateStart();
                $dateEnd = $tourService->getDateEnd();
                $daysCount = $dateEnd->diff($dateStart)->format("%a");
                $option = $tourService->getOption();
                if(!empty($option)) {
                    $this->price += $option->getPrice()*$daysCount;
                }
                break;
            case 'option':
                $option = $tourService->getOption();
                if(!empty($option)){
                    $this->price += $option->getPrice();
                }
                break;
        }
    }

    private function setBatPrice($tour)
    {
        $room = $tour->getRoom();
        if(!empty($room)) {
            $this->price += $this->daysCount*$room->getPrice();
        }
        $apartment = $tour->getApartment();
        if(!empty($apartment)) {
            $this->price += $this->daysCount*$apartment->getPrice();
        }
    }

    private function setDaysCount($tour)
    {
        $dateStart = $tour->getDateStart();
        $dateEnd = $tour->getDateEnd();
        $this->daysCount = $dateEnd->diff($dateStart)->format("%a");
    }

    protected function isNewOrders()
    {
        return $this->isNewOrders;
    }

    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);
        $user  = $this->getConfigurationPool()->getContainer()->get('security.context')->getToken()->getUser();
        $query
            ->andWhere($query->getRootAlias().'.moderator = :moderator')
            ->andWhere($query->getRootAlias().'.isCancel = :isCancel')
            ->setParameter('moderator', $user->getId())
            ->setParameter('isCancel', false)
        ;
        return $query;
    }

    // Поля, отображаемые в списках
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id','text',['label' => 'form.label.number'])
            ->add('fromCountry', null, ['label' => 'form.label.fromCountry'])
            ->add('toCountry', null, ['label' => 'form.label.toCountry'])
            ->add('toCity', null, ['label' => 'admin.layout.city', 'template' => 'SonataMediaBundle:MediaAdmin:list_custom.html.twig'])
            ->add('dateStart', null, ['label' => 'admin.layout.dateStart'])
            ->add('dateEnd', null, ['label' => 'admin.layout.dateEnd'])
            ->add('author', null, ['label' => 'form.label.author', 'template' => 'SonataMediaBundle:MediaAdmin:list_custom.html.twig'])
            ->add('price', null, ['label' => 'form.label.price'])
            ->add('_action', 'actions', [
                'actions' => [
                    'edit'   => ['template' => 'NetcastUrestMainBundle:CRUD:list__action_edit.html.twig'],
                ]
            ])
        ;
    }

    /**
     * Set base route name
     * @param string $name
     */
    public function setBaseRouteName($name)
    {
        $this->baseRouteName = $name;
    }

    /**
     * Set base route pattern
     * @param string $pattern
     */
    public function setBaseRoutePattern($pattern)
    {
        $this->baseRoutePattern = $pattern;
    }

    /**
     * Set class name label (used for breadcrumbs)
     * @param string $label
     * @see classnameLabel
     */
    public function setClassNameLabel($label)
    {
        $this->classnameLabel = $label;
    }
}