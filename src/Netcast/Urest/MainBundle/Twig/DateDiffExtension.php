<?php

    namespace Netcast\Urest\MainBundle\Twig;

    class DateDiffExtension extends \Twig_Extension
    {
        public function getFilters()
        {
            return array(
                'dateDiff' => new \Twig_Filter_Method($this, 'dateDiff'),
            );
        }

        public function dateDiff($date,$format = null)
        {
            $now = new \DateTime();
            $interval = $date->diff($now);
            if(null === $format)
            {
                $diff = ($now->getTimestamp()-$date->getTimestamp());
                if($diff < 60)
                    return $interval->format('%S секунд');
                if($diff < 3600)
                    return $interval->format('%I минут %S секунд');

                return $interval->format('%D дней %H часов %I минут %S секунд');
            }
            if($format == 'days') {
                return date_diff($now,$date)->days;
            }
            return $interval->format($format);
        }

        public function getName()
        {
            return 'dateDiff';
        }
    }