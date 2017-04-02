<?php

namespace Netcast\Urest\MainBundle\Entity;

/**
 * CurrencyRate
 */
class CurrencyRate
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
    private $currency_code;

    /**
     * @var string
     */
    private $currency_icon;

    /**
     * @var boolean
     */
    private $display;

    /**
     * @var float
     */
    private $rate;


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
     *
     * @return CurrencyRate
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
     * Set currencyCode
     *
     * @param string $currencyCode
     *
     * @return CurrencyRate
     */
    public function setCurrencyCode($currencyCode)
    {
        $this->currency_code = $currencyCode;

        return $this;
    }

    /**
     * Get currencyCode
     *
     * @return string
     */
    public function getCurrencyCode()
    {
        return $this->currency_code;
    }

    /**
     * Set currencyIcon
     *
     * @param string $currencyIcon
     *
     * @return CurrencyRate
     */
    public function setCurrencyIcon($currencyIcon)
    {
        $this->currency_icon = $currencyIcon;

        return $this;
    }

    /**
     * Get currencyIcon
     *
     * @return string
     */
    public function getCurrencyIcon()
    {
        return $this->currency_icon;
    }

    /**
     * Set display
     *
     * @param boolean $display
     *
     * @return CurrencyRate
     */
    public function setDisplay($display)
    {
        $this->display = $display;

        return $this;
    }

    /**
     * Get display
     *
     * @return boolean
     */
    public function getDisplay()
    {
        return $this->display;
    }

    /**
     * Set rate
     *
     * @param float $rate
     *
     * @return CurrencyRate
     */
    public function setRate($rate)
    {
        $this->rate = $rate;

        return $this;
    }

    /**
     * Get rate
     *
     * @return float
     */
    public function getRate()
    {
        return $this->rate;
    }

    public function __toString()
    {
        return (is_null($this->currency_code)) ? 'New' : $this->currency_code;
    }
}

