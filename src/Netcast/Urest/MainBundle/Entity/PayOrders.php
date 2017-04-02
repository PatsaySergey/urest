<?php

namespace Netcast\Urest\MainBundle\Entity;

/**
 * PayOrders
 */
class PayOrders
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $amount;


    /**
     * @var string
     */
    private $pre_amount;


    /**
     * @var \DateTime
     */
    private $created;

    /**
     * @var \DateTime
     */
    private $pay_date;

    /**
     * @var \Netcast\Urest\MainBundle\Entity\CustomTourOrder
     */
    private $order;

    /**
     * @var \Netcast\Urest\MainBundle\Entity\TourOrder
     */
    private $tour_order;

    /**
     * @var \Application\Sonata\UserBundle\Entity\User
     */
    private $user;


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
     * Set amount
     *
     * @param string $amount
     *
     * @return PayOrders
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return string
     */
    public function getAmount()
    {
        return $this->amount;
    }


    /**
     * Set pre_amount
     *
     * @param string $pre_amount
     *
     * @return PayOrders
     */
    public function setPreAmount($pre_amount)
    {
        $this->pre_amount = $pre_amount;

        return $this;
    }

    /**
     * Get pre_amount
     *
     * @return string
     */
    public function getPreAmount()
    {
        return $this->pre_amount;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return PayOrders
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
     * Set payDate
     *
     * @param \DateTime $payDate
     *
     * @return PayOrders
     */
    public function setPayDate($payDate)
    {
        $this->pay_date = $payDate;

        return $this;
    }

    /**
     * Get payDate
     *
     * @return \DateTime
     */
    public function getPayDate()
    {
        return $this->pay_date;
    }

    /**
     * Set order
     *
     * @param \Netcast\Urest\MainBundle\Entity\CustomTourOrder $order
     *
     * @return PayOrders
     */
    public function setOrder(\Netcast\Urest\MainBundle\Entity\CustomTourOrder $order = null)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Get order
     *
     * @return \Netcast\Urest\MainBundle\Entity\CustomTourOrder
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Set tourOrder
     *
     * @param \Netcast\Urest\MainBundle\Entity\TourOrder $tourOrder
     *
     * @return PayOrders
     */
    public function setTourOrder(\Netcast\Urest\MainBundle\Entity\TourOrder $tourOrder = null)
    {
        $this->tour_order = $tourOrder;

        return $this;
    }

    /**
     * Get tourOrder
     *
     * @return \Netcast\Urest\MainBundle\Entity\TourOrder
     */
    public function getTourOrder()
    {
        return $this->tour_order;
    }

    /**
     * Set user
     *
     * @param \Application\Sonata\UserBundle\Entity\User $user
     *
     * @return PayOrders
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

