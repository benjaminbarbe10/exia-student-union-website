<?php

namespace BDE\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class NewArticleType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', TextType::class, array('label' => 'Nom de l\'article'));
        $builder->add('description', TextType::class, array('label' => 'Description'));
        $builder->add('picture', FileType::class, array('label' => 'Ajouter une image'));
        $builder->add('pricettc', NumberType::class, array('label' => 'Prix (en €)'));

    }

    public function getName()
    {
        return 'newarticle';
    }
}