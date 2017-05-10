<?php

namespace Netcast\Urest\MainBundle\Twig;

class LanguagesExtension extends \Twig_Extension
{

    protected $container;
    protected $doctrine;

    public function __construct($container = null,$doctrine)
    {
        $this->container = $container;
        $this->doctrine = $doctrine;
    }

    public function getFunctions()
    {
        return array(
            'getLanguages' => new \Twig_Function_Method($this, 'getLanguages',['is_safe' => ['html']]),
            'langList' => new \Twig_Function_Method($this, 'langList'),
        );
    }

    public function getLanguages($isMobil = false)
    {
        $request = $this->container->get('request_stack')->getCurrentRequest();
        $currentUrl = $request->getUri();
        $currentUrlArray = explode('/',$currentUrl);
        $currLang = $request->getLocale();
        $Langs = $this->doctrine->getRepository('Netcast\Urest\MainBundle\Entity\Language')->findBy(['display' => true]);
        $data['currentLang'] = strtoupper($currLang);
        $data['isMobil'] = $isMobil;
        $LangsToDisplay = [];
        foreach($Langs as $lang) {
            if($lang->getAlias() != $currLang) {
                $currentUrlArray[3] = $lang->getAlias();
                $url = implode('/',$currentUrlArray);
                $LangsToDisplay[strtoupper($lang->getAlias())] = $url;
            }
        }
        $data['LangsToDisplay'] = $LangsToDisplay;
        return $this->container->get('templating')->render("NetcastUrestMainBundle:Twig:languages.html.twig", $data);
    }

    public function langList() {
        $langs = $this->doctrine->getRepository('NetcastUrestMainBundle:Language')->getList(0,1);
        $result = [];
        foreach ($langs as $key => $lang) {
            $result[$key] = [
                'alias' => $lang->getAlias(),
                'title' => $lang->getTitle(),
                'id' => $lang->getId(),
            ];
        }
        return $result;
    }

    public function getName()
    {
        return 'languages';
    }
}