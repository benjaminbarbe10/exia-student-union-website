<?php
/**
 * Created by PhpStorm.
 * Users: CaSSoSSiSSe
 * Date: 10/04/2018
 * Time: 09:59
 */

namespace BDE\ContactBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class EnquiryType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('email');
        $builder->add('subject',TextType::class, array('label' => 'Sujet'));
        $builder->add('body',TextType::class, array('label' => 'Message'));
    }

    public function getName()
    {
        return 'contact';
    }
}