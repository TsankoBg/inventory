<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use App\Entity\Product;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class ProductType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => array(
                    'class' => "form-control",
                    'id' => 'name-input',
                    'placeholder' => 'Име на продукта'
                ),
            ])
            ->add('barcode', TextType::class, [
                'attr' => array(
                    'class' => 'form-control',
                    'id' => 'barcode-input',
                    'placeholder' => 'Баркод'
                ),
            ])
            ->add('file', FileType::class, ['required' => false,])

            ->add('quantity', NumberType::class, [
                'attr' => array(
                    'class' => 'form-control',
                    'id' => 'qunatity-input',
                    'type' => 'number',
                    'value' => '0',
                    'placeholder' => '0'
                ),
                'html5'=>true,
                'required' => false,
            ])
            ->add('price', NumberType::class, [
                'attr' => array(
                    'class' => "form-control",
                    'id' => 'price-input',
                    'type' => 'number',
                    'placeholder' => '0'
                ),
                'html5'=>true,
            ])
            ->add('price_bought', NumberType::class, [
                'attr' => array(
                    'class' => "form-control",
                    'id' => 'price_bought-input',
                    'type' => 'number',
                    'placeholder' => '0'
                ),
                'html5'=>true,
                'required' => false,
            ]);
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
