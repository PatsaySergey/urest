<?php

namespace Netcast\Urest\MainBundle\Twig;

use Sonata\AdminBundle\Twig\Extension\SonataAdminExtension as BaseSonataAdminExtension;
use Sonata\AdminBundle\Admin\FieldDescriptionInterface;
use Sonata\AdminBundle\Exception\NoValueException;
use Netcast\Urest\MainBundle\Admin\GroupAdmin;
use Netcast\Urest\MainBundle\Form\Type\SecurityRolesType;

class SonataAdminExtension extends BaseSonataAdminExtension
{
    /**
     * {@inheritdoc}
     */
    public function getValueFromFieldDescription($object, FieldDescriptionInterface $fieldDescription, array $params = array())
    {
        if (isset($params['loop']) && $object instanceof \ArrayAccess) {
            throw new \RuntimeException('remove the loop requirement');
        }

        try {
            $value = $fieldDescription->getValue($object);
        } catch (NoValueException $e) {
            $value = null;
            if ($fieldDescription->getAssociationAdmin()) {
                $value = $fieldDescription->getAssociationAdmin()->getNewInstance();
            }
        }
        if ($fieldDescription->getAdmin() instanceof GroupAdmin && is_array($value)) {
            $result = array();
            $roles  = SecurityRolesType::$roles;
            foreach ($value as $role) {
                foreach ($roles as $key => $roleGroup) {
                    if (isset($roleGroup[$role])) {
                        $result[] = ($key ? $key . ' - ' : '') . $roleGroup[$role];
                    }
                }
            }

            return implode('<br>', $result);
        }

        return $value;
    }
}