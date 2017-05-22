<?php
/**
 * Created by PhpStorm.
 * User: Patsay Sergey
 * Date: 09.05.2017
 * Time: 9:30
 */

namespace Netcast\Urest\MainBundle\Entity;


class TourContent extends IsI18NEntity
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $accommodation;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $announcement;

    /**
     * @var string
     */
    private $description;

    /**
     * @var Language
     */
    private $lang;

    /**
     * @var \Netcast\Urest\MainBundle\Entity\Tour
     */
    private $tour;

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
     * @return TourContent
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

    /**
     * Set lang
     *
     * @param Language $lang
     * @return TourContent
     */
    public function setLang(Language $lang)
    {
        $this->lang = $lang;

        return $this;
    }

    /**
     * Get lang
     *
     * @return Language
     */
    public function getLang()
    {
        return $this->lang;
    }

    /**
     * Set accommodation
     *
     * @param string $accommodation
     * @return TourContent
     */
    public function setAccommodation($accommodation)
    {
        $this->accommodation = $accommodation;

        return $this;
    }

    /**
     * Get accommodation
     *
     * @return string
     */
    public function getAccommodation()
    {
        return $this->accommodation;
    }

    /**
     * Set announcement
     *
     * @param string $announcement
     * @return TourContent
     */
    public function setAnnouncement($announcement)
    {
        $this->announcement = $announcement;

        return $this;
    }

    /**
     * Get announcement
     *
     * @return string
     */
    public function getAnnouncement()
    {
        return $this->announcement;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return TourContent
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set tour
     *
     * @param \Netcast\Urest\MainBundle\Entity\Tour $tour
     * @return TourContent
     */
    public function setTour(\Netcast\Urest\MainBundle\Entity\Tour $tour = null)
    {
        $this->tour = $tour;

        return $this;
    }

    /**
     * Get tour
     *
     * @return \Netcast\Urest\MainBundle\Entity\Tour
     */
    public function getTour()
    {
        return $this->tour;
    }

    public function __toString()
    {
        return $this->title;
    }
}