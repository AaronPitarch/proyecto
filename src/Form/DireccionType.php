<?php

namespace App\Form;

use App\Entity\Cliente;
use App\Entity\Direccion;
use App\Entity\Municipios;
use App\Entity\Provincias;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DireccionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('calle', TextType::class)
            ->add('numero', TextType::class)
            ->add('puerta_piso_escalera', TextType::class)
            ->add('cod_postal', TextType::class)
            ->add('cliente', EntityType::class, ['class' => Cliente::class])
            ->add('provincia', EntityType::class, ['class' => Provincias::class])
            ->add('municipio', EntityType::class, ['class' => Municipios::class])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Direccion::class,
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
    public function getName(){
        return '';
    }
}
