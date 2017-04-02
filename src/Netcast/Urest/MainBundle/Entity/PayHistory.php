<?php

namespace Netcast\Urest\MainBundle\Entity;

/**
 * PayHistory
 */
class PayHistory
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $data;

    /**
     * @var string
     */
    private $sign;

    /**
     * @var string
     */
    private $sign_sys;

    /**
     * @var string
     */
    private $amount;

    /**
     * @var string
     */
    private $status;

    /**
     * @var \DateTime
     */
    private $created;

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
     * Set data
     *
     * @param string $data
     *
     * @return PayHistory
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Get data
     *
     * @return string
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set $status
     *
     * @param string $status
     *
     * @return PayHistory
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }



    /**
     * Set sign
     *
     * @param string $sign
     *
     * @return PayHistory
     */
    public function setSign($sign)
    {
        $this->sign = $sign;

        return $this;
    }

    /**
     * Get sign
     *
     * @return string
     */
    public function getSign()
    {
        return $this->sign;
    }

    /**
     * Set signSys
     *
     * @param string $signSys
     *
     * @return PayHistory
     */
    public function setSignSys($signSys)
    {
        $this->sign_sys = $signSys;

        return $this;
    }

    /**
     * Get signSys
     *
     * @return string
     */
    public function getSignSys()
    {
        return $this->sign_sys;
    }

    /**
     * Set amount
     *
     * @param string $amount
     *
     * @return PayHistory
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
     * Set created
     *
     * @param \DateTime $created
     *
     * @return PayHistory
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
     * Set order
     *
     * @param \Netcast\Urest\MainBundle\Entity\CustomTourOrder $order
     *
     * @return PayHistory
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
     * @return PayHistory
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
     * @return PayHistory
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

    public function __toString()
    {
        return $this->getCreated()->format('Y-m-d').' '.$this->getAmount().' €';
    }
}

