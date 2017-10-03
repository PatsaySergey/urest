<?php

namespace Netcast\Urest\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AboutUs
 */
class AboutUs extends HasI18NEntity
{
    /**
     * @var integer
     */
    private $id;

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

    /**
     * @var \Application\Sonata\MediaBundle\Entity\Media
     */
    private $image;



    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    protected $about_content;

    protected $contentField = 'about_content';


    /**
     * Add about_content
     *
     * @param \Netcast\Urest\MainBundle\Entity\AboutUsContent $about_content
     * @return AboutUs
     */
    public function addAboutContent(AboutUsContent $about_content)
    {
        $this->about_content[] = $about_content;

        return $this;
    }

    /**
     * Remove about_content
     *
     * @param \Netcast\Urest\MainBundle\Entity\AboutUsContent $about_content
     */
    public function removeAboutContent(AboutUsContent $about_content)
    {
        $this->about_content->removeElement($about_content);
    }

    /**
     * Get about_content
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAboutContent()
    {
        return $this->about_content;
    }


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->about_content = new \Doctrine\Common\Collections\ArrayCollection();
    }


    public function __toString()
    {
        return $this->getContent() ? $this->getContent()->getTitle() : '';
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
     * Set created
     *
     * @param \DateTime $created
     * @return AboutUs
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
     * @return AboutUs
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
     * @return AboutUs
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

    /**
     * Set image
     *
     * @param \Application\Sonata\MediaBundle\Entity\Media $image
     * @return AboutUs
     */
    public function setImage(\Application\Sonata\MediaBundle\Entity\Media $image = null)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \Application\Sonata\MediaBundle\Entity\Media
     */
    public function getImage()
    {
        return $this->image;
    }

}