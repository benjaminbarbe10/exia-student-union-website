<?php

namespace BDE\EventBundle\Form;
use BDE\EventBundle\Entity\Events_picture;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use BDE\EventBundle\Form\Events_pictureType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;



class EventsType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {


        $builder
            ->add('name', TextType::class)
            ->add('date', DateTimeType::class)
            ->add('place', TextType::class)
            ->add('description', TextareaType::class)
            ->add('type', ChoiceType::class, array(
                'choices' => array(
                    'Ponctuelle' => 'ponctuelle',
                    'Mensuel' => 'mensuel'
                )
            ))
            ->add('pricettc', NumberType::class)
            ->add('events_picture', CollectionType::class,array(
                'entry_type' => Events_pictureType::class,
                'allow_add' => true,
                'by_reference' => false,
            ))
            ->add('save',      SubmitType::class)
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BDE\EventBundle\Entity\Events'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'bde_eventbundle_events';
    }


}
