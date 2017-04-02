<?php

namespace Netcast\Urest\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller
{
    public function showPluginsAction()
    {
        return $this->render('NetcastUrestMainBundle:Admin:plugin.html.twig');
    }



}
