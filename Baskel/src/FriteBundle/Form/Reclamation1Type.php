<?php

namespace FriteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Reclamation1Type extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('objetR', ChoiceType::class , [
                'choices'  => [
                    'Produit non conforme' => 'Produit non conforme',
                    'Produit abime' => 'Produit abime',
                    'Produit non recu' => 'Produit non recu',
                    'Livraison non recu' => 'Livraison non recu',
                    'Livraison non conforme' => 'Livraison non conforme',
                    'Probleme de facturation' => 'Probleme de facturation',
                    'Autres..' => 'Autres..',

                ],])
            ->add('detailsR', TextareaType::class, array(
                'data' => 'Donnez-nous plus de details'));

    }/**
 * {@inheritdoc}
 */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'FriteBundle\Entity\Reclamation'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'fritebundle_reclamation';
    }


}
