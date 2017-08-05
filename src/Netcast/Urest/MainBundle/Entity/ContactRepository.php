<?php

    namespace Netcast\Urest\MainBundle\Entity;

    use Doctrine\ORM\EntityRepository;

    /**
     * CityRepository
     *
     * This class was generated by the Doctrine ORM. Add your own custom
     * repository methods below.
     */
    class ContactRepository extends EntityRepository
    {
        public function getContactCountry()
        {
            $qb = $this->createQueryBuilder('contact')
                ->select(['country_content.title','country.id','country.coordinates'])
                ->join('contact.city', 'city')
                ->join('city.region', 'region')
                ->join('region.country', 'country', 'WITH', 'region.country = country.id')
                ->join('country.country_content', 'country_content')
                ->groupBy('country.id')
            ;
            return $qb->getQuery()->getResult();
        }

        public function getContactByCountry($lang,$country)
        {
            $qb = $this->createQueryBuilder('contact')
                ->select('contact')
                ->join('contact.city', 'city')
                ->join('city.region', 'region')
                ->join('region.country', 'country')
                ->where('country = :country')
                ->setParameter('country', $country)
            ;
            return $qb->getQuery()->getResult();
        }

    }
