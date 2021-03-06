<?php

    namespace Netcast\Urest\MainBundle\Controller;

    use Netcast\Urest\MainBundle\Controller\MainController as Controller;

    class PostController extends Controller
    {

        private function buildMapOptions($posts)
        {
            $result = [];
            $result['type'] = 'post';
            $result['items'] = [];
            foreach($posts as $post) {
                $item = [];
                $coordinates = explode(',',$post->getCoordinates());
                $item['description'] = $post->getPreviewText();

                $postImages = $post->getImages();
                foreach($postImages as $row) {
                    if($row->getMain()) {
                        $provider = $this->container->get($row->getMedia()->getProviderName());
                        $item['img'] = $provider->generatePublicUrl($row->getMedia(), 'reference');
                    }
                }

                $item['title'] = $post->getTitle();
                $item['url'] = $this->generateUrl('netcast_urest_post_view',['category' => $post->getCategory()->getAlias(), 'alias' => $post->getAlias()]);
                $mapIcon = $post->getLocatorIcon();
                if($mapIcon) {
                    $provider = $this->container->get($mapIcon->getProviderName());
                    $iconUrl = $provider->generatePublicUrl($mapIcon,'reference');
                    $item['icon'] = $iconUrl;
                }

                if(count($coordinates) == 2) {
                    $item['lat'] = $coordinates[0];
                    $item['lng'] = $coordinates[1];
                    $result['items'][] = $item;
                }
            }
            return json_encode($result);
        }

        public function categoriesAction()
        {
            $lang = $this->get('request')->getLocale();
            $em = $this->getDoctrine()->getManager();
            $urlNoPhoto = $this->container->getParameter('url_no_photo');

            $categoryRepository = $em->getRepository('Netcast\Urest\MainBundle\Entity\BlogCategory');
            $postRepository = $em->getRepository('Netcast\Urest\MainBundle\Entity\BlogPost');

            $postCategories = $categoryRepository->findCategories($lang);

            $posts = $postRepository->findPostByCategory($lang,null);

            $mapOptions = $this->buildMapOptions($posts);

            return $this->render('NetcastUrestMainBundle:Post:category.html.twig', [
                'posts' => $posts,
                'mapOptions' => $mapOptions,
                'categories' => $postCategories,
                'urlNoPhoto' => $urlNoPhoto,
                'currCategory' => null
            ]);
        }

        public function viewCategoryAction($category)
        {
            $lang = $this->get('request')->getLocale();
            $em = $this->getDoctrine()->getManager();
            $urlNoPhoto = $this->container->getParameter('url_no_photo');

            $categoryRepository = $em->getRepository('Netcast\Urest\MainBundle\Entity\BlogCategory');
            $postRepository = $em->getRepository('Netcast\Urest\MainBundle\Entity\BlogPost');

            $category = $categoryRepository->findOneBy(['alias' => $category, 'lang' => $lang]);
            if(!$category) {
                throw $this->createNotFoundException($this->get('translator')->trans('page404',[],'NetcastUrestMainBundle'));
            }

            $posts = $postRepository->findPostByCategory($lang,$category->getId());
            $mapOptions = $this->buildMapOptions($posts);
            $postCategories = $categoryRepository->findCategories($lang);
            $currCategory = $category->getId();

            return $this->render('NetcastUrestMainBundle:Post:category.html.twig', [
                'posts' => $posts,
                'mapOptions' => $mapOptions,
                'categories' => $postCategories,
                'urlNoPhoto' => $urlNoPhoto,
                'currCategory' => $currCategory
            ]);
        }

        public function viewPostAction($category,$alias)
        {
            $lang = $this->get('request')->getLocale();
            $em = $this->getDoctrine()->getManager();
            $postRepository = $em->getRepository('Netcast\Urest\MainBundle\Entity\BlogPost');
            $post = $postRepository->findOneBy(['alias' => $alias, 'lang' => $lang]);
            $categoryRepository = $em->getRepository('Netcast\Urest\MainBundle\Entity\BlogCategory');
            $category = $categoryRepository->findOneBy(['alias' => $category, 'lang' => $lang]);
            if(!$category) {
                throw $this->createNotFoundException($this->get('translator')->trans('page404',[],'NetcastUrestMainBundle'));
            }
            $otherPosts = $postRepository->getLastPostsByCategory($lang, $category->getId(), 3, $post->getId());
            if (!$post) {
                throw $this->createNotFoundException($this->get('translator')->trans('page404',[],'NetcastUrestMainBundle'));
            }

            $mapOptions = $this->buildMapOptions($otherPosts);
            $postCategories = $categoryRepository->findCategories($lang);
            $currCategory = $category->getId();
            return $this->render('NetcastUrestMainBundle:Post:post.html.twig', [
                'post' => $post,
                'mapOptions' => $mapOptions,
                'otherPosts' => $otherPosts,
                'categories' => $postCategories,
                'currCategory' => $currCategory
            ]);
        }
    }
