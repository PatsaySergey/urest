<?php
/**
 * Created by PhpStorm.
 * User: Patsay Sergey
 * Date: 16.05.2017
 * Time: 19:32
 */

namespace Netcast\Urest\MainBundle\Listener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Netcast\Urest\MainBundle\Entity\HasI18NEntity;
use Symfony\Component\DependencyInjection\ContainerInterface;

class DoctrinePostLoadListener
{

    private $container;

    public function __construct(ContainerInterface $container) {
        $this->container = $container;
    }

    public function postLoad(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof HasI18NEntity) {
            return;
        }
        $entityManager = $args->getEntityManager();
        $currLocale = $this->container->get('request')->getLocale();
        $defLocale = $this->container->getParameter('default.locale');
        $currentLanguage = $entityManager->getRepository('NetcastUrestMainBundle:Language')->findOneBy(['alias' => $currLocale]);
        $defaultLanguage = $entityManager->getRepository('NetcastUrestMainBundle:Language')->findOneBy(['alias' => $defLocale]);

        $entity->setCurrentLocale($currentLanguage);
        $entity->setDefaultLocale($defaultLanguage);


        // ... do something with the Product
    }
}