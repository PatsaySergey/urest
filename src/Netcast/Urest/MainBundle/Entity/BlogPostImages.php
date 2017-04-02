<?php

namespace Netcast\Urest\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BlogPostImages
 */
class BlogPostImages
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
     * @var \Netcast\Urest\MainBundle\Entity\BlogPost
     */
    private $post;

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
     * @return BlogPostImages
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
     * Set post
     *
     * @param \Netcast\Urest\MainBundle\Entity\BlogPost $post
     * @return BlogPostImages
     */
    public function setPost(\Netcast\Urest\MainBundle\Entity\BlogPost $post = null)
    {
        $this->post = $post;

        return $this;
    }

    /**
     * Get post
     *
     * @return \Netcast\Urest\MainBundle\Entity\BlogPost 
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * Set media
     *
     * @param \Application\Sonata\MediaBundle\Entity\Media $media
     * @return BlogPostImages
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
