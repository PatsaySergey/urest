<?php

namespace Netcast\Urest\MainBundle\Twig;

use Doctrine\ORM\EntityManager;

/**
 * @author kvk
 */
class LenguageMenuExtension extends \Twig_Extension {

    /**
     * Doctrine entity manager
     * @var EntityManager
     */
    private $em;

    public function __construct(EntityManager $em) {
        $this->em = $em;
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
        $rep = $this->em->getRepository('Netcast\Urest\MainBundle\Entity\Language');
        return $rep->getList($active, $display);
    }
}