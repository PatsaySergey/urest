<?php
/**
 * Created by PhpStorm.
 * User: Patsay Sergey
 * Date: 24.05.2017
 * Time: 20:14
 */

namespace Netcast\Urest\MainBundle\Entity;


class BlogTagContent extends IsI18NEntity
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $title;

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
     * Set title
     *
     * @param string $title
     * @return BlogTagContent
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }
}