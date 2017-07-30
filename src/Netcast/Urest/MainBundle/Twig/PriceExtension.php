<?php

namespace Netcast\Urest\MainBundle\Twig;

class PriceExtension extends \Twig_Extension
{

    protected $container;
    protected static $icon;
    protected $doctrine;
    protected $defaultCurrency = 'EUR';
    protected $defaultCurrencyIcon = 'fa-eur';

    public function __construct($container = null,$doctrine)
    {
        $this->container = $container;
        $this->doctrine = $doctrine;
    }

    public function getFunctions()
    {
        return array(
            'getPrice' => new \Twig_Function_Method($this, 'getPrice',['is_safe' => ['html']]),
            'getIcon' => new \Twig_Function_Method($this, 'getIcon',['is_safe' => ['html']]),
        );
    }

    public function getPrice($price,$withoutCurrency = false)
    {
        $request = $this->container->get('request_stack')->getCurrentRequest();
        $cookies = $request->cookies;
        $currCurrencyCode = null;
        $currency = null;
        if ($cookies->has('CURRENCY')) {
            $currCurrencyCode = $cookies->get('CURRENCY');
            $currency = $this->doctrine->getRepository('Netcast\Urest\MainBundle\Entity\CurrencyRate')->findOneBy(['currency_code' => $currCurrencyCode, 'display' => true]);
        }
        if(is_null($currency)) {
            $rate = 1;
            $icon = $this->defaultCurrencyIcon;
        } else {
            $rate = $currency->getRate();
            $icon = $currency->getCurrencyIcon();
        }
        self::$icon = $icon;

        $price = round($price*$rate);

        if($withoutCurrency) {
            return $price;
        }
        return '<i class="fa '.$icon.'"></i> '.$price;
    }

    public function getIcon()
    {
        if(!self::$icon) {
            $currency = null;
            $request = $this->container->get('request_stack')->getCurrentRequest();
            $cookies = $request->cookies;
            if ($cookies->has('CURRENCY')) {
                $currCurrencyCode = $cookies->get('CURRENCY');
                $currency = $this->doctrine->getRepository('Netcast\Urest\MainBundle\Entity\CurrencyRate')->findOneBy(['currency_code' => $currCurrencyCode, 'display' => true]);
            }
            $icon = is_null($currency) ? $this->defaultCurrencyIcon : $currency->getCurrencyIcon();
            self::$icon = $icon;
        }
        return '<i class="fa '.self::$icon.'"></i>';
    }

    public function getName()
    {
        return 'price';
    }
}