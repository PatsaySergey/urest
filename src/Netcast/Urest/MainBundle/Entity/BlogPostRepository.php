<?php

    namespace Netcast\Urest\MainBundle\Entity;

    use Doctrine\ORM\EntityRepository;


    class BlogPostRepository extends EntityRepository
    {

        public function findPostByCategory($categoryId = null)
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
                ->andWhere('post.datePublish <= :datePublish')
                ->setParameter('main',true)
                ->setParameter('active', true)
                ->setParameter('deleted', false)
                ->setParameter('datePublish', new \DateTime())
                ->orderBy('post.created','DESC')
            ;
            return $qb->getQuery()->getResult();
        }

        public function getLastPostsByCategory($categoryId, $limit, $currPost = false)
        {
            $qb = $this->createQueryBuilder('post')
                ->select(['post','images'])
                ->join('post.category', 'category', 'WITH', 'category.id = :id')
                ->leftJoin('post.images', 'images', 'WITH', 'images.main = :main')
                ->where('post.active = :active')
                ->andWhere('post.deleted = :deleted')
                ->andWhere('post.datePublish <= :datePublish')
                ->setParameter('id',$categoryId)
                ->setParameter('main',true)
                ->setParameter('active', true)
                ->setParameter('deleted', false)
                ->setParameter('datePublish', new \DateTime())
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

        public function getLastPosts($limit)
        {
            $qb = $this->createQueryBuilder('post')
                ->select(['post','images'])
                ->leftJoin('post.images', 'images', 'WITH', 'images.main = :main')
                ->where('post.active = :active')
                ->andWhere('post.deleted = :deleted')
                ->andWhere('post.datePublish <= :datePublish')
                ->setParameter('main',true)
                ->setParameter('active', true)
                ->setParameter('deleted', false)
                ->setParameter('datePublish', new \DateTime())
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
                ->join('post.post_content', 'content', 'WITH', 'content.lang = :lang')
                ->where('post.active = :active')
                ->andWhere('post.deleted = :deleted')
                ->andWhere('content.title like :search OR content.content like :search')
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