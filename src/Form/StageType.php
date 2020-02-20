<?php

namespace App\Form;

use App\Entity\Stage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use App\Form\EntrepriseType;
use App\Entity\Formation;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class StageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', TextType::class)
            ->add('mail', EmailType::class)
            ->add('description', TextareaType::class)
            ->add('entreprise', EntrepriseType::class)
            ->add('formations', EntityType::class, ['class' => Formation::class,
                                                   'choice_label' => 'nomComplet',
                                                   'expanded' => true,
                                                   'multiple' => true])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Stage::class,
        ]);
    }
}
