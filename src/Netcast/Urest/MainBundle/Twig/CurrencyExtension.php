<?php

namespace Netcast\Urest\MainBundle\Twig;

class CurrencyExtension extends \Twig_Extension
{

    protected $container;
    protected $doctrine;
    protected $defaultCurrency = ['code' => 'EUR', 'icon' => 'fa-eur'];

    public function __construct($container = null,$doctrine)
    {
        $this->container = $container;
        $this->doctrine = $doctrine;
    }

    public function getFunctions()
    {
        return array(
            'getCurrencies' => new \Twig_Function_Method($this, 'getCurrencies',['is_safe' => ['html']]),
        );
    }

    public function getCurrencies($isMobil = false)
    {
        $request = $this->container->get('request_stack')->getCurrentRequest();
        $cookies = $request->cookies;
        $currCurrencyCode = null;
        if ($cookies->has('CURRENCY')) {
            $currCurrencyCode = $cookies->get('CURRENCY');
        }

        $currencies = $this->doctrine->getRepository('Netcast\Urest\MainBundle\Entity\CurrencyRate')->findBy(['display' => true]);
        $currencyArray = [];
        foreach($currencies as $currency) {
            $currencyArray[] = $currency->getCurrencyCode();
        }
        if(!in_array($currCurrencyCode,$currencyArray) || is_null($currCurrencyCode)) {
            $currCurrencyCode = $this->defaultCurrency['code'];
        }
        $currCurrency = $this->doctrine->getRepository('Netcast\Urest\MainBundle\Entity\CurrencyRate')->findOneBy(['currency_code' => $currCurrencyCode, 'display' => true]);
        $currCurrencyArray = [];
        if(!is_null($currCurrency)) {
            $currCurrencyArray['code'] = $currCurrency->getCurrencyCode();
            $currCurrencyArray['icon'] = $currCurrency->getCurrencyIcon();
        } else {
            $currCurrencyArray = $this->defaultCurrency;
        }

        $currencyDisplayArray = [];
        $currencyDisplayArray[$this->defaultCurrency['code']] = $this->defaultCurrency;
        foreach($currencies as $currency) {
            $currencyDisplayArray[$currency->getCurrencyCode()]['code'] = $currency->getCurrencyCode();
            $currencyDisplayArray[$currency->getCurrencyCode()]['icon'] = $currency->getCurrencyIcon();
        }
        unset($currencyDisplayArray[$currCurrencyCode]);

        $data['currCurrency'] = $currCurrencyArray;
        $data['currencies'] = $currencyDisplayArray;
        return $this->container->get('templating')->render("NetcastUrestMainBundle:Twig:currency.html.twig", $data);
    }

    public function getName()
    {
        return 'currency';
    }
}