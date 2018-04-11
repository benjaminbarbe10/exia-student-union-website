<?php
/**
 * Created by PhpStorm.
 * User: CaSSoSSiSSe
 * Date: 11/04/2018
 * Time: 14:40
 */

namespace BDE\AccountBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class RegisterType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add((string)'email');
        $builder->add('password');
    }

    public function getName()
    {
        return 'login';
    }
}