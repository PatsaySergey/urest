<?php

    namespace Netcast\Urest\MainBundle\Entity;

    use Doctrine\ORM\EntityRepository;


    class BlogCategoryRepository extends EntityRepository
    {
        /**
         * @param string(2) $lang
         * @return array
         */
        public function findCategories($lang)
        {
            $qb = $this->createQueryBuilder('c')
                ->select('c')
                ->where('c.lang = :lang')
                ->setParameter('lang', $lang)
                ->orderBy('c.id','ASC')
            ;
            return $qb->getQuery()->getResult();
        }

        /**
         * @param string $categoryAlias
         * @param array $categories  query result
         * @return bool
         */
        public function existsCategory($categoryAlias,$categories=[])
        {
            if (empty($categories))
                $categories = $this->findCategories('en');

            $exist = false;
            foreach ($categories as $item) {
                if (method_exists(get_class($item),'getAlias') && $item->getAlias() === $categoryAlias) {
                    $exist = true;
                    break;
                }
            }
            return $exist;
        }
    }