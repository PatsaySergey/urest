<?php

    namespace Netcast\Urest\MainBundle\Entity;

    use Doctrine\ORM\EntityRepository;


    class BlogPostRepository extends EntityRepository
    {

        public function findPostByCategory($lang,$categoryId = null)
        {
            $qb = $this->createQueryBuilder('post')
                ->select(['post','images']);
                if(!is_null($categoryId)) {
                    $qb->join('post.category', 'category', 'WITH', 'category.id = :id')
                        ->setParameter('id',$categoryId);
                }
            $qb->leftJoin('post.images', 'images', 'WITH', 'images.main = :main')
                ->where('post.active = :active')
                ->andWhere('post.deleted = :deleted')
                ->andWhere('post.lang = :lang')
                ->andWhere('post.datePublish <= :datePublish')
                ->setParameter('main',true)
                ->setParameter('active', true)
                ->setParameter('deleted', false)
                ->setParameter('datePublish', new \DateTime())
                ->setParameter('lang', $lang)
                ->orderBy('post.title','ASC')
            ;
            return $qb->getQuery()->getResult();
        }

        public function getLastPostsByCategory($lang, $categoryId, $limit, $currPost = false)
        {
            $qb = $this->createQueryBuilder('post')
                ->select(['post','images'])
                ->join('post.category', 'category', 'WITH', 'category.id = :id')
                ->leftJoin('post.images', 'images', 'WITH', 'images.main = :main')
                ->where('post.active = :active')
                ->andWhere('post.deleted = :deleted')
                ->andWhere('post.lang = :lang')
                ->andWhere('post.datePublish <= :datePublish')
                ->setParameter('id',$categoryId)
                ->setParameter('main',true)
                ->setParameter('active', true)
                ->setParameter('deleted', false)
                ->setParameter('datePublish', new \DateTime())
                ->setParameter('lang', $lang)
                ->setFirstResult(0)
                ->setMaxResults($limit)
                ->orderBy('post.created','DESC')
            ;
            if($currPost) {
                $qb->andWhere('post.id != :cpId')
                   ->setParameter('cpId', $currPost);
            }

            return $qb->getQuery()->getResult();
        }

        public function getLastPosts($lang, $limit)
        {
            $qb = $this->createQueryBuilder('post')
                ->select(['post','images'])
                ->leftJoin('post.images', 'images', 'WITH', 'images.main = :main')
                ->where('post.active = :active')
                ->andWhere('post.deleted = :deleted')
                ->andWhere('post.lang = :lang')
                ->andWhere('post.datePublish <= :datePublish')
                ->setParameter('main',true)
                ->setParameter('active', true)
                ->setParameter('deleted', false)
                ->setParameter('datePublish', new \DateTime())
                ->setParameter('lang', $lang)
                ->setFirstResult(0)
                ->setMaxResults($limit)
                ->orderBy('post.created','DESC')
            ;
            return $qb->getQuery()->getResult();
        }

        public function searchPosts($lang, $search)
        {
            $qb = $this->createQueryBuilder('post')
                ->select(['post','images'])
                ->leftJoin('post.images', 'images', 'WITH', 'images.main = :main')
                ->where('post.active = :active')
                ->andWhere('post.deleted = :deleted')
                ->andWhere('post.title like :search OR post.content like :search')
                ->andWhere('post.lang = :lang')
                ->andWhere('post.datePublish <= :datePublish')
                ->setParameter('search',"%{$search}%")
                ->setParameter('main',true)
                ->setParameter('active', true)
                ->setParameter('deleted', false)
                ->setParameter('datePublish', new \DateTime())
                ->setParameter('lang', $lang)
                ->orderBy('post.created','DESC')
            ;
            return $qb->getQuery()->getResult();
        }

    }