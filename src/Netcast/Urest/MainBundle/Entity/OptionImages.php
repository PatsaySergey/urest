<?php

namespace Netcast\Urest\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OptionImages
 */
class OptionImages
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var boolean
     */
    private $main;

    /**
     * @var \Netcast\Urest\MainBundle\Entity\Options
     */
    private $option;

    /**
     * @var \Application\Sonata\MediaBundle\Entity\Media
     */
    private $media;


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
     * Set main
     *
     * @param boolean $main
     * @return OptionImages
     */
    public function setMain($main)
    {
        $this->main = $main;

        return $this;
    }

    /**
     * Get main
     *
     * @return boolean 
     */
    public function getMain()
    {
        return $this->main;
    }

    /**
     * Set option
     *
     * @param \Netcast\Urest\MainBundle\Entity\Options $option
     * @return OptionImages
     */
    public function setOption(\Netcast\Urest\MainBundle\Entity\Options $option = null)
    {
        $this->option = $option;

        return $this;
    }

    /**
     * Get option
     *
     * @return \Netcast\Urest\MainBundle\Entity\Options 
     */
    public function getOption()
    {
        return $this->option;
    }

    /**
     * Set media
     *
     * @param \Application\Sonata\MediaBundle\Entity\Media $media
     * @return OptionImages
     */
    public function setMedia(\Application\Sonata\MediaBundle\Entity\Media $media = null)
    {
        $this->media = $media;

        return $this;
    }

    /**
     * Get media
     *
     * @return \Application\Sonata\MediaBundle\Entity\Media 
     */
    public function getMedia()
    {
        return $this->media;
    }
}
