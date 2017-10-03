<?php

/**
 * This file is part of the <name> project.
 *
 * (c) <yourname> <youremail>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Application\Sonata\UserBundle\Entity;

use Sonata\UserBundle\Entity\BaseUser as BaseUser;

class User extends BaseUser
{
    /**
     * @var integer $id
     */
    protected $id;

    /**
     * @var \Application\Sonata\MediaBundle\Entity\Media
     */
    private $avatar;

    private $country;
    private $city;

    private $provider;
    private $identity;

    protected $facebookId;

    public function serialize()
    {
        return serialize(array($this->facebookId, parent::serialize()));
    }

    public function unserialize($data)
    {
        list($this->facebookId, $parentData) = unserialize($data);
        parent::unserialize($parentData);
    }

    /**
     * @param string $facebookId
     * @return void
     */

    public function setFacebookId($facebookId)
    {
        $this->facebookId = $facebookId;
    }

    /**
     * @return string
     */
    public function getFacebookId()
    {
        return $this->facebookId;
    }

    /**
     * Get id
     *
     * @return integer $id
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * Set country
     *
     * @param string $country
     * @return User
     */
    public function setCountry($country = null)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return User
     */
    public function setCity($city = null)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set avatar
     *
     * @param \Application\Sonata\MediaBundle\Entity\Media $avatar
     * @return User
     */
    public function setAvatar(\Application\Sonata\MediaBundle\Entity\Media $avatar = null)
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * Get avatar
     *
     * @return \Application\Sonata\MediaBundle\Entity\Media
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * @var \Netcast\Urest\MainBundle\Entity\Country
     */
    private $managerCountry;


    /**
     * Set managerCountry
     *
     * @param \Netcast\Urest\MainBundle\Entity\Country $managerCountry
     *
     * @return User
     */
    public function setManagerCountry(\Netcast\Urest\MainBundle\Entity\Country $managerCountry = null)
    {
        $this->managerCountry = $managerCountry;

        return $this;
    }

    /**
     * Get managerCountry
     *
     * @return \Netcast\Urest\MainBundle\Entity\Country
     */
    public function getManagerCountry()
    {
        return $this->managerCountry;
    }
    /**
     * @var boolean
     */
    private $isModerator = '0';


    /**
     * Set isModerator
     *
     * @param boolean $isModerator
     *
     * @return User
     */
    public function setIsModerator($isModerator)
    {
        $this->isModerator = $isModerator;

        return $this;
    }

    /**
     * Get isModerator
     *
     * @return boolean
     */
    public function getIsModerator()
    {
        return $this->isModerator;
    }

    /**
     * @param string $identity
     * @return $this
     */
    public function setIdentity($identity)
    {
        $this->identity = $identity;
        return $this;
    }

    /**
     * @return string
     */
    public function getIdentity()
    {
        return $this->identity;
    }

    /**
     * @param string $provider
     * @return $this
     */
    public function setProvider($provider)
    {
        $this->provider = $provider;
        return $this;
    }

    /**
     * @return string
     */
    public function getProvider()
    {
        return $this->provider;
    }
}