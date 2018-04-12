<?php
/**
 * Created by PhpStorm.
 * Users: CaSSoSSiSSe
 * Date: 10/04/2018
 * Time: 09:59
 */

namespace BDE\AccountBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;

class LoginType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('email', EmailType::class, array(
        ));
        $builder->add('password', PasswordType::class, array(
        ));
    }

    public function getName()
    {
        return 'login';
    }
}