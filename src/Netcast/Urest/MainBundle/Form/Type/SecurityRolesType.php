<?php

namespace Netcast\Urest\MainBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SecurityRolesType extends AbstractType
{
    public static $roles = array(
        'Добавление/редактирование пользователей' => array(
            'ROLE_ADD_EDIT_SUPER_ADMIN'   => 'Суперадмин',
            'ROLE_ADD_EDIT_ADMIN'         => 'Админ',
            'ROLE_ADD_EDIT_SUPER_MANAGER' => 'Суперменеджер',
            'ROLE_ADD_EDIT_MANAGER'       => 'Менеджер',
            'ROLE_ADD_EDIT_EDITOR'        => 'Редактор',
            'ROLE_ADD_EDIT_USER'          => 'Пользователь/клиент',
        ),
        'Добавление/редактирование' => array(
            'ROLE_ADD_EDIT_CITY_COUNTRY'         => 'Стран/городов',
            'ROLE_ADD_EDIT_TOURS'                => 'Готовых туров',
            'ROLE_ADD_EDIT_INFO_IN_TOUR_BUILDER' => 'Информации в турбилдер',
            'ROLE_ADD_EDIT_BLOG_SECTION'         => 'Разделов (рубрик) в блог',
            'ROLE_ADD_EDIT_BLOG_ARTICLE_META'    => 'Статей/мета тегов в блог',
            'ROLE_ADD_EDIT_ARTICLE'              => 'Статей в справочник',
            'ROLE_ADD_EDIT_CONTACTS'             => 'Контактов',
        ),
        'Заказы' => array(
            'ROLE_ORDER_PROCESSING' => 'Обработка заказов',
            'ROLE_ORDER_STATISTIC'  => 'Просмотр статистики заказов',
        ),
        '' => array(
            'ROLE_EDIT_MAIN_PAGE'         => 'Редактирование главной страницы',
            'ROLE_ADD_PHOTO_VIDEO_FOOTER' => 'Добавление фотографий/видео в футер сайта',
            'ROLE_ADD_FAQ'                => 'Добавление в FAQ',
            'ROLE_EDIT_ABOUT_US'          => 'Редактирование О нас',
            'ROLE_MODERATE_REVIEWS'       => 'Модерирование отзывов',
            'ROLE_ADD_REVIEWS'            => 'Добавление отзывов на лицевой части сайта',
        ),
    );

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $formBuilder, array $options)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $attr = $view->vars['attr'];

        if (isset($attr['class']) && empty($attr['class'])) {
            $attr['class'] = 'sonata-medium';
        }

        $view->vars['attr'] = $attr;
        $view->vars['mainChoices'] = $options['choices'];
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => null,
            'choices'    => self::$roles,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'choice';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'sonata_security_roles';
    }
}