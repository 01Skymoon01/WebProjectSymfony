<?php

namespace BaskelBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('date', DateType::class,array(
            'widget'=>'single_text'
        ))->add('nom')->add('description')->add('nbParticipants')->add('responsable')->add('whyattend')
            ->add('image',FileType::class,array('label'=>'Image','data_class'=>null))
            ->add('ajouter',SubmitType::class);

    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BaskelBundle\Entity\Event'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'baskelbundle_event';
    }


}
