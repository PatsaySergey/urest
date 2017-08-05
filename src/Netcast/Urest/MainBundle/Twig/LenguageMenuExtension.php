<?php

namespace Netcast\Urest\MainBundle\Twig;

use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\Container;

/**
 * @author kvk
 */
class LenguageMenuExtension extends \Twig_Extension {

    /**
     * Doctrine entity manager
     * @var EntityManager
     */
    private $em;
    private $container;

    public function __construct(EntityManager $em, Container $container) {
        $this->em = $em;
        $this->container = $container;
    }

    public function getFunctions()
    {
        return [
            'languagemenu' => new \Twig_Function_Method($this, 'getLanguageMenu'),
        ];
    }

    public function getName() {
        return 'netcast.urest.twig.languagemenu';
    }

    public function getLanguageMenu($active = 0, $display = 0) {
        $request = $this->container->get('request');
        $uri = $request->getRequestUri();
        $uriArray = explode('/',$uri);
        $rep = $this->em->getRepository('Netcast\Urest\MainBundle\Entity\Language');
        $langs = $rep->getList($active, $display);
        foreach ($langs as $lng) {
            $langAlias = $lng->getAlias();
            $uriArray[1] = $langAlias;
            $url = implode('/',$uriArray);
            $lng->setUrl($url);
        }
        return $langs;
    }
}