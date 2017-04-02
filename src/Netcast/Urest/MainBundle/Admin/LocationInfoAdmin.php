<?php

namespace Netcast\Urest\MainBundle\Admin;

use Netcast\Urest\MainBundle\Admin\BasicAdmin as Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Validator\Constraints\NotBlank;

class LocationInfoAdmin extends Admin
{
    /**
     * Location info type city|country
     * @var string
     */
    private $type;

    /**
     * Entity Manager
     * @var EntityManager
     */
    protected  $em;

    public function __construct($code, $class, $baseControllerName) {
        parent::__construct($code, $class, $baseControllerName);
        $this->em = null;
        $this->type = null;
    }

    /**
     * Set entity manager
     * @param \Doctrine\ORM\EntityManager $em
     */
    public function setEntityManager(EntityManager $em) {
        $this->em = $em;
    }

    /**
     * Set location info type country|city
     * @param string $type
     */
    public function setType($type) {
        if ($type) $this->type = $type;
    }

    /**
     * Set base route name
     * @param string $name
     */
    public function setBaseRouteName($name) {
        $this->baseRouteName = $name;
    }

    /**
     * Set base route pattern
     * @param string $pattern
     */
    public function setBaseRoutePattern($pattern) {
        $this->baseRoutePattern = $pattern;
    }

    /**
     * Set class name label (used for breadcrumbs)
     * @param string $label
     * @see classnameLabel
     */
    public function setClassNameLabel($label) {
        $this->classnameLabel = $label;
    }

    // перед созданием
    public function prePersist($item)
    {
        $user = $this->getSecurityContext()->getToken()->getUser();
        $item->setUser($user);
        $item->setLang($this->getLanguage());
        $item->setCreated(new \DateTime());
        $item->setUpdated(new \DateTime());
        foreach($item->getLocationinfoImage() as $img) {
            if($img->getMedia() !== null)
                $img->setLocationInfo($item);
            else
                $item->removeLocationinfoImage($img);
        }
    }

    // перед обновлением
    public function preUpdate($item)
    {
        $item->setUpdated(new \DateTime());
        foreach($item->getLocationinfoImage() as $img) {
            if($img->getMedia() !== null)
                $img->setLocationInfo($item);
            else
                $item->removeLocationinfoImage($img);
        }
    }

    public function createChildrenQuery($query,$parent)
    {
        $query
            ->andWhere($query->getRootAlias().'.parent = :parent')
            ->setParameter('parent', $parent->getId())
        ;
        return $query;
    }

    // Поля, отображаемые в формах create/edit
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper = $this->checkAlias($formMapper);

        $class = 'sonata.admin.locinfo_country';
        if ($this->type=='city')
        {
            $class = 'sonata.admin.locinfo_city';
            $parentCountry = $this->getParentEntity('Netcast\Urest\MainBundle\Entity\LocationInfo');
        }

        $info = $this->getSubject();
        $datePublish = ($info->getDatePublish() != null)?$info->getDatePublish():new \DateTime();
        $now = new \DateTime();
        $formMapper
            ->with('admin.tour.left',['class' => 'col-md-6', 'translation_domain' => 'NetcastUrestMainBundle'])
            ->add('title', 'text', [
                'label' => 'form.label.title',
                'trim' => true,
                'required' => true,
                'attr' => [
                    'maxlength' => '255',
                ]],
                ['admin_code' => $class]
            );
            if ($this->type=='city')
            {

                $query = $this->em->createQueryBuilder('l')
                    ->select('l')
                    ->from('NetcastUrestMainBundle:LocationInfo', 'l')
                    ->where('l.parent IS NULL');
                if ($parentCountry == null)
                {
                    $formMapper->add('parent', 'sonata_type_model', [
                            'label' => 'form.label.country',
                            'query' => $query,
                            'required' => false,
                        ],  ['admin_code' => $class]
                    );
                }
                else
                {
                    $formMapper->add('parent', 'sonata_type_model', [
                            'label' => 'form.label.country',
                            'query' => $query,
                            'data' => $parentCountry,
                            'required' => false,
                        ],  ['admin_code' => $class]
                    );
                }
            }
        $formMapper->add('alias', 'text', [
                'label' => 'form.label.alias',
                'trim' => true,
                'required' => true,
                ],
                ['admin_code' => $class]
            )
            ->add('coordinates', 'text', [
                'label' => 'form.label.coordinates',
                'trim' => true,
                'required' => true,
                ],
                ['admin_code' => $class]
            )
            ->add('icon', 'urest_media_type', [
                'label' => 'form.label.icon',
                'provider' => 'sonata.media.provider.image',
                'translation_domain' => 'NetcastUrestMainBundle',
                'required' => false
            ])
            ->end()
            ->with('admin.tour.right',['class' => 'col-md-6', 'translation_domain' => 'NetcastUrestMainBundle'])
            ->add('datePublish', 'sonata_type_date_picker', [
                    'label' => 'form.label.date_publish',
                    'data' => $datePublish,
                     ],
                    ['admin_code' => $class]
            )
            ->add('user', 'label_text', [
                'label' => 'form.label.author',
                'trim' => true,
                'required' => false,
                'data' => ($this->getSubject()->getUser() !== null)?$this->getSecurityContext()->getToken()->getUser():$this->getSubject()->getUser(),
                'mapped' => false
            ])
            ->add('created', 'label_text', [
                'label' => 'form.label.created',
                'trim' => true,
                'required' => false,
                'data' => ($this->getSubject()->getCreated() !== null)?$this->getSubject()->getCreated():$now,
                'mapped' => false
            ])
            ->add('updated', 'label_text', [
                'label' => 'form.label.updated',
                'trim' => true,
                'required' => false,
                'data' => ($this->getSubject()->getUpdated() !== null)?$this->getSubject()->getUpdated():$now,
                'mapped' => false
            ])
            ->end()
            ->with('admin.empty',['class' => 'clear', 'translation_domain' => 'NetcastUrestMainBundle'])
            ->add('clear','hidden',['mapped' => false])
            ->end()
            ->with('admin.tour.end',['class' => 'col-md-12', 'translation_domain' => 'NetcastUrestMainBundle'])
            ->add('preview_text', 'textarea', [
                    'label' => 'form.label.blog_preview_text',
                    'attr' => array('rows' => 10),
                    'required' => true,
                ],
                ['admin_code' => $class]
            )
            ->add('content', 'ckeditor', [
                    'label' => 'form.label.description',
                    'attr' => array('class' => 'ckeditor', 'rows' => 20),
                    'config_name' => 'admin_config',
                    'constraints' => [new NotBlank()],
                ],
                ['admin_code' => $class]
            )
            ->add('active', 'checkbox', [
                    'label' => 'form.label.active',
                    'required' => false,
                ],
                ['admin_code' => $class]
            )
            ->add('locationinfo_image', 'urest_collection', [
                'label' => 'form.label.images',
                'type' => 'netcast_urest_media_collection_form',
                'options' => [
                    'label' => false,
                    'required' => false,
                    'data_class' => 'Netcast\Urest\MainBundle\Entity\LocationInfoImage',
                ],
                'by_reference' => false,
                'allow_add' => true,
                'allow_delete' => false,
                'required' => false,
                ],
                ['admin_code' => $class]
            )
            ->add('video', 'urest_collection', [
                'label' => 'form.label.video',
                'type' => 'sonata_media_type',
                'options' => [
                    'label' => false,
                    'required' => false,
                    'data_class' => 'Application\Sonata\MediaBundle\Entity\Media',
                    'provider' => 'sonata.media.provider.youtube'
                ],
                'by_reference' => false,
                'allow_add' => true,
                'allow_delete' => false,
                'required' => false,
                ],
                ['admin_code' => $class]
            );

        // show parent to city only
        $formMapper->end();
    }

    public function createQuery($context = 'list') {

        $valid = ['city','country'];
        if ($this->type == null || !in_array($this->type,$valid)){
            throw new \RuntimeException("Configure type");
        }

        $query = parent::createQuery($context);

        $query
            ->andWhere($query->getRootAlias().'.lang = :lang')
            ->setParameter('lang', $this->getLanguage())
        ;

        if ($this->type=='country')
            $query->andWhere($query->getRootAlias().'.parent IS NULL');

        if ($this->type=='city')
            $query->andWhere($query->getRootAlias().'.parent IS NOT NULL');

        return $query;
    }

    protected function configureListFields(ListMapper $listMapper)
    {

        $listMapper
            ->add('id','text',['label' => 'form.label.number'])
            ->add('title', null, ['label' => 'form.label.title'])
            ->add('user', null, ['label' => 'form.label.author', 'template' => 'SonataMediaBundle:MediaAdmin:list_custom.html.twig'])
            ->add('active', null, ['label' => 'form.label.active'])
            ->add('_action', 'actions', [
                'actions' => [
                    'edit'   => ['template' => 'NetcastUrestMainBundle:CRUD:list__action_edit.html.twig'],
                    'delete' => ['template' => 'NetcastUrestMainBundle:CRUD:list__action_delete.html.twig'],
                ]
            ])
        ;
    }


}