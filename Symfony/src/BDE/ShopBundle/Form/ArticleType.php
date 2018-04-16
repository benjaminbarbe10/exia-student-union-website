<?php

namespace BDE\ShopBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class ArticleType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('quantity', ChoiceType::class);
        $builder->add('add', SubmitType::class, array('label' => 'Ajouter au panier'));
    }

    public function getName()
    {
        return 'addcart';
    }
}