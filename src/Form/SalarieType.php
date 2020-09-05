<?php

namespace App\Form;

use App\Entity\Entreprise;
use App\Entity\Salarie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SalarieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class)
            ->add('prenom', TextType::class)
            ->add('dateNaissance', DateType::class, array(
                'years' => range(date('Y'), date('Y') - 70),
                'label' => 'Date de naissance',
                'format' => 'ddMMMMyyyy'
            ))
            ->add('adresse', TextType::class)
            ->add('cp', TextType::class)
            ->add('ville', TextType::class)
            ->add('dateEmbauche', DateType::class, array(
                'years' => range(date('Y'), date('Y') - 70),
                'label' => 'Date de naissance',
                'format' => 'ddMMMMyyyy'
            ))
            ->add('entreprise', EntityType::class, array(
                'class' => Entreprise::class,
                'choice_label' => 'raisonSociale',
            ))
            ->add('Valider',SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Salarie::class,
        ]);
    }
}
