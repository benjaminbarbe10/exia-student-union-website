<?php

namespace BDE\ShopBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class CartType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('add', SubmitType::class, array('label' => 'Commander'));
    }

    public function getName()
    {
        return 'command';
    }
}