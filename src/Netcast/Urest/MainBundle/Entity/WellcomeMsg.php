<?php

namespace Netcast\Urest\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * WellcomeMsg
 */
class WellcomeMsg
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $lang;

    /**
     * @var string
     */
    private $message_guest;

    /**
     * @var string
     */
    private $message_user;

    /**
     * @var \DateTime
     */
    private $created;

    /**
     * @var \DateTime
     */
    private $updated;

    /**
     * @var \Application\Sonata\UserBundle\Entity\User
     */
    private $user;

    public function __toString()
    {
        return (string) $this->id;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set lang
     *
     * @param string $lang
     * @return WellcomeMsg
     */
    public function setLang($lang)
    {
        $this->lang = $lang;

        return $this;
    }

    /**
     * Get lang
     *
     * @return string 
     */
    public function getLang()
    {
        return $this->lang;
    }

    /**
     * Set message_guest
     *
     * @param string $messageGuest
     * @return WellcomeMsg
     */
    public function setMessageGuest($messageGuest)
    {
        $this->message_guest = $messageGuest;

        return $this;
    }

    /**
     * Get message_guest
     *
     * @return string 
     */
    public function getMessageGuest()
    {
        return $this->message_guest;
    }

    /**
     * Set message_user
     *
     * @param string $messageUser
     * @return WellcomeMsg
     */
    public function setMessageUser($messageUser)
    {
        $this->message_user = $messageUser;

        return $this;
    }

    /**
     * Get message_user
     *
     * @return string 
     */
    public function getMessageUser()
    {
        return $this->message_user;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return WellcomeMsg
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return WellcomeMsg
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime 
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set user
     *
     * @param \Application\Sonata\UserBundle\Entity\User $user
     * @return WellcomeMsg
     */
    public function setUser(\Application\Sonata\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Application\Sonata\UserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }
}
