<?php

namespace BaskelBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RDVType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('objetRDV', ChoiceType::class , [
                'choices'  => [
                    'Reparation' => 'Reparation',
                    'Maintenance technique' => 'Maintenance technique',
                    'Rendez-vous technicien' => 'Rendez-vous technicien',
                    'Probleme de facturation' => 'Probleme de facturation',
                    'Autres..' => 'Autres..',

                ],])
            ->add('dateRDV')
            ->add('detailsRDV', TextareaType::class, array(
                'data' => 'Donnez-nous plus de details'))
            ->add('Ajouter',SubmitType::class);


    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BaskelBundle\Entity\RDV'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'baskelbundle_rdv';
    }


}
