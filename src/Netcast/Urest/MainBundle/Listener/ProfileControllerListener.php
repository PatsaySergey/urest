<?php

namespace Netcast\Urest\MainBundle\Listener;

use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Netcast\Urest\MainBundle\Controller\ProfileController;
use Application\Sonata\UserBundle\Entity\User;
use Symfony\Component\HttpFoundation\RedirectResponse;

class ProfileControllerListener
{
    public function onKernelController(FilterControllerEvent $event)
    {
        $controller = $event->getController();
        if(!is_array($controller))
        {
            return;
        }
        $controllerObject = $controller[0];
        if(is_object($controllerObject) && $controllerObject instanceof ProfileController)
        {
            $user = $controllerObject->getUser();
            if(!($user instanceof User)) {
                $url = $controllerObject->generateUrl('netcast_urest_main_page_default');
                $event->setController(function() use ($url) {
                    return new RedirectResponse($url);
                });
            }
        }
    }
}
