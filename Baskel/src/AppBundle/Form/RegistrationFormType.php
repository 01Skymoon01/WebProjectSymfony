<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseRegistrationFormType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;

class RegistrationFormType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nom')->add('prenom')->add('dateNaiss',BirthdayType::class, [
            'widget' => 'single_text',

            'attr' => array(
                'class'=>'input-group-sm'
            ),

        ])
            ->add('numtel1')->add('numtel2');
    }
    public function getParent()
    {
        return BaseRegistrationFormType::class;
    }



}
