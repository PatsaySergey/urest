<?php

namespace Netcast\Urest\MainBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Security\Core\SecurityContext;

/**
 * Description of MediaCollectionFormType
 *
 * @author kvk
 */
class MediaCollectionFormType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if($options['provider'] == 'sonata.media.provider.image')
        {
        $builder
            ->add('media', 'urest_media_type', [
                'label' => false,
                'context' => $options['context'],
                'provider' => $options['provider'],
                'translation_domain' => 'NetcastUrestMainBundle'
            ]);
        }
        else{
            $builder
                ->add('media', 'sonata_media_type', [
                    'label' => 'form.label.video',
                    'context' => $options['context'],
                    'provider' => $options['provider'],
                    'translation_domain' => 'NetcastUrestMainBundle'
                ]);
        }
        $builder
            ->add('main', 'checkbox', [
                'attr' => ['rel' => 'main_cb'],
                'required' => false,
                'label' => 'form.label.main',
                'translation_domain' => 'NetcastUrestMainBundle'
            ])
        ;
    }
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults([
            'context' => 'post',
            'provider' => 'sonata.media.provider.image'
        ]);
    }
    public function getName() {
        return 'netcast_urest_media_collection_form';
    }
}