<?php

namespace OC\PlatformBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use OC\PlatformBundle\Form\ImageType;

class AdvertType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date', 'date')
            ->add('title', 'text')
            ->add('author', 'text')
            ->add('content', 'textarea')
            ->add('published', 'checkbox', array('required' => false))
            ->add('image', new ImageType(), array('required' => false))
            // ->add('categories','collection', array(
            //     'type' => new CategoryType(),
            //     'allow_add' => true,
            //     'allow_delete' => true
            // ))
            ->add('categories', 'entity', array(
                'class' => 'OCPlatformBundle:Category',
                'property' => 'name',
                'multiple' => true
            ))
            ->add('save', 'submit')
        ;

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function(FormEvent $event){
            $advert = $event->getData();
            if (null === $advert) {
                return;
            }

            if (!$advert->getPublished() || null === $advert->getId()) {
                $event->getForm()->add('published', 'checkbox', array('required' => false));
            } else {
                $event->getForm()->remove('published');
            }
        });
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'OC\PlatformBundle\Entity\Advert'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'oc_platformbundle_advert';
    }
}
