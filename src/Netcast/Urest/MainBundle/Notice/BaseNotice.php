<?php

    namespace Netcast\Urest\MainBundle\Notice;

    use Symfony\Component\Security\Core\SecurityContextInterface;
    use Doctrine\ORM\EntityManager;


class BaseNotice
{
    /**
     * @var \Symfony\Component\Security\Core\SecurityContextInterface
     */
    protected $securityContext;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    /**
     * @var locale
     */
    protected $locale;

    /**
     * Set Security Context
     */
    public function setSecurityContext(SecurityContextInterface $securityContext) {
        $this->securityContext = $securityContext;
    }

    /**
     * Set Entity Manager
     */
    public function setEntityManager(EntityManager $em) {
        $this->em = $em;
    }

    /**
     * Set Current Locale
     */
    public function setCurrentLocale($locale) {
        $this->locale = $locale;
    }

    protected function getCurrentLocale()
    {
        return $this->locale;
    }

    protected function getUser()
    {
        return $this->securityContext->getToken()->getUser();
    }


}