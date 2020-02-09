<?php

namespace BaskelBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProduitsType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('ref_p')
            ->add('nomP')
            ->add('genreP')
            ->add('couleurP')

            ->add('quantiteP')
            ->add('prixP')
            ->add('marqueP')
            ->add('description')

            ->add('image',FileType::class,array('label' => 'Image'))

            ->add('ref_c',EntityType::class,
                    array('class'=>'BaskelBundle:Categories',
                    'choice_label'=>'libelle' ,
                        'placeholder' => 'Categorie')
                )
            ->add('Ajouter',SubmitType::class);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BaskelBundle\Entity\Produits'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'baskelbundle_produits';
    }


}
