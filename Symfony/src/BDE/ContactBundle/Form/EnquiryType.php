<?php
/**
 * Created by PhpStorm.
 * User: CaSSoSSiSSe
 * Date: 10/04/2018
 * Time: 09:59
 */

namespace BDE\ContactBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class EnquiryType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('email');
        $builder->add('subject');
        $builder->add('body');
    }

    public function getName()
    {
        return 'contact';
    }
}