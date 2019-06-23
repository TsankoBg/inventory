<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use App\Entity\Product;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ProductType extends AbstractType
{

public function buildForm(FormBuilderInterface $builder, array $options)
{
    $builder
        ->add('name',TextType::class,[
            'attr' => array( 
            'class' => "form-control",
            'id' => 'name-input',
            'placeholder' => 'Име на продукта'),
        ])
        ->add('barcode',TextType::class,[
            'attr' => array( 
            'class' => 'form-control',
            'id' => 'barcode-input',
            'placeholder' => 'Баркод'),
        ])
        ->add('quantity',NumberType::class,[
            'attr' => array( 
            'class' => 'form-control',
            'id' => 'qunatity-input',
            'placeholder' => '0'),
        ])
        ->add('price',NumberType::class,[
            'attr' => array( 
            'class' => "form-control",
            'id' => 'price-input',
            'placeholder' => '0'),
        ])
        ->add('Add', SubmitType::class,[
            'attr' => ['class' => 'btn btn-primary'] ,
        ])
    ;
}
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Product::class
        ));
    }
}