<?php
/**
 * Created by PhpStorm.
 * User: CaSSoSSiSSe
 * Date: 11/04/2018
 * Time: 14:40
 */

namespace BDE\AccountBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class RegisterType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('email', EmailType::class, array(
        ));
        $builder->add('name', TextType::class, array(
            'label' => 'Prénom',
        ));
        $builder->add('surname', TextType::class, array(
            'label' => 'Nom',
        ));
        $builder->add('password', RepeatedType::class, array(
            'type' => PasswordType::class,
            'first_options'  => array('label' => 'Mot de passe'),
            'second_options' => array('label' => 'Recopier mot de passe'),
        ));
    }

    public function getName()
    {
        return 'register';
    }
}