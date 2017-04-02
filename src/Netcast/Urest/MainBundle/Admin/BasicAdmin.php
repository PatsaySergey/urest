<?php

namespace Netcast\Urest\MainBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;

class BasicAdmin extends Admin
{
    /**
     * Security context
     * @var SecurityContextInterface
     */
    private $securityContext;

    /**
     * The number of result to display in the list
     *
     * @var integer
     */
    protected $maxPerPage = 1000000;

    /**
     * ContainerInterface
     * @var ContainerInterface
     */
    protected $container;

    protected $childrenManager = null;

    protected $parentManager   = null;

    protected $childrenObject = [];

    protected $parentId = null;

    protected $showDelete = false;

    public function getRole()
    {
        return 'ROLE_SONATA_ADMIN';
    }

    public function setShowDelete($showDelete)
    {
        $this->showDelete = $showDelete;
    }

    protected function checkAlias(FormMapper $formMapper)
    {
        $formMapper->getFormBuilder()->addEventListener(FormEvents::POST_BIND, function(FormEvent $event) {
            $modManager = $this->getModelManager();
            $alias      = $event->getForm()->get('alias')->getData();
            $checkAlias = $modManager->findOneBy($this->getClass(), ['alias' => $alias]);

            if (count($checkAlias) && $checkAlias->getId() != $this->getSubject()->getId()) {
                $error = new FormError($this->trans('form.error.alias_exist', [], 'NetcastUrestMainBundle'));
                $event->getForm()->get('alias')->addError($error);
            }
        });
        return $formMapper;
    }

    /**
     *
     * @access protected
     * @return \Symfony\Component\Security\Core\SecurityContext
     */
    protected function getSecurityContext()
    {
        if (null == $this->securityContext) {
            $this->securityContext = $this->container->get('security.context');
        }
        return $this->securityContext;
    }

    public function setParentId($id)
    {
        $this->parentId = $id;
    }

    public function getParentId()
    {
        return $this->parentId;
    }

    /**
     * Set Security Context
     */
    public function setSecurityContext(SecurityContextInterface $securityContext)
    {
        $this->securityContext = $securityContext;
    }

    public function getLanguage()
    {
        return $this->getRequest()->getLocale();
    }

    public function getBatchActions()
    {
        return [];
    }

    public function setContainer(Container $container)
    {
        $this->container = $container;
    }

    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);
        if (method_exists($this->getClass(), 'setLang')) {
            $query
                ->andWhere($query->getRootAlias() . '.lang = :lang')
                ->setParameter('lang', $this->getLanguage())
            ;
        }
        return $query;
    }

    public function hasDeleteLabel()
    {
        return method_exists($this->getClass(), 'setDeleted');
    }

    public function initChildren()
    {
        $subject      = $this->getSubject();
        $adminManager = $this->childrenManager;
        $query        = $adminManager->getModelManager()->createQuery($adminManager->getClass());
        $query        = ($this->getSubject()->getId() !== null) ? $adminManager->createChildrenQuery($query, $subject) : null;
        $result       = [];
        if ($query !== null) {
            $query
                ->andWhere($query->getRootAlias() . '.lang = :lang')
                ->setParameter('lang', $this->getLanguage())
            ;

            foreach ($query->getQuery()->getResult() as $key => $row) {
                foreach ($adminManager->getList()->getElements() as $listEl) {
                    $getter                           = 'get' . $listEl->getName();
                    if (method_exists($row, $getter)) $result[$key][$listEl->getName()] = $row->$getter();
                }
                $result[$key]['id'] = $row->getId();
            }
        }
        $this->setChildrenObject($result);
        return $adminManager;
    }

    public function setChildrenManager($childrenManager)
    {
        $this->childrenManager = $childrenManager;
    }

    public function getChildrenManager()
    {
        return $this->childrenManager;
    }

    public function setParentManager($parentManager)
    {
        $this->parentManager = $parentManager;
    }

    public function getParentManager()
    {
        return $this->parentManager;
    }

    public function getChildrenId()
    {
        return $this->childrenId;
    }

    private function setChildrenObject($childrenObject)
    {
        $this->childrenObject = $childrenObject;
    }

    public function getChildrenObject()
    {
        return $this->childrenObject;
    }

    protected function getParentEntity($className)
    {
        $parent = ($this->getRequest()->query->has('parent')) ? $this->getRequest()->query->get('parent') : null;
        if ($parent != null) {
            $em = $this->getModelManager()->getEntityManager($className);

            return $em->find($className, $parent);
        } else {
            return null;
        }
    }

    protected function toPositive($item)
    {
        $cost = $item->getCost();
        if ($cost < 0) {
            $item->setCost(abs($cost));
        }
    }
}