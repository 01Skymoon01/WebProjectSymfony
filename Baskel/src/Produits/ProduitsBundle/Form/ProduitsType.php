<?php

namespace Produits\ProduitsBundle\Form;

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
            ->add('genreP', ChoiceType::class,array(
                'choices' => array(
                    'Genre' => null,
                   'Homme' => 'homme',
                   'Femme' => 'femme',
                    'Enfant' => 'enfant',
                ),'multiple' => false
            ))
            ->add('couleurP', ChoiceType::class,
                array(
                    'choices' => array(
                        'Noir' => 'black',
                        'Bleu' => 'blue',
                        'Vert' => 'green',
                        'Jaune' => 'yellow',
                        'Rose' => 'pink',
                        'Rouge' => 'darkred',
                        'mauve' => 'purple',
                        'Blanc' => 'whitesmoke',
                    ),'expanded'  => true,
                    'multiple'  => true
                ))

            ->add('quantiteP')
            ->add('prixP')
            ->add('marqueP')
            ->add('description')

            ->add('image',FileType::class,array('label' => 'Image',
                'data_class' => null,
                'required' => false,

            ))

            ->add('ref_c',EntityType::class,
                array('class'=>'ProduitsBundle:Categories',
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
            'data_class' => 'Produits\ProduitsBundle\Entity\Produits'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'produits_produitsbundle_produits';
    }


}
