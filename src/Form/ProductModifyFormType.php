<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductModifyFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => ['class' => 'form-control'],
                'label' => "Nom :"
            ])
            ->add('price', MoneyType::class, [
                'attr' => ['class' => 'form-control'],
                'label' => "Prix :",
                //'divisor' => 100,
            ])
            ->add('is_highlighted', CheckboxType::class, [
                'label' => "Mis en avant :",
                'required'=> false
             ])
            //->add('image', Filetype::class, [
            //    'attr' => ['class' => 'form-control'],
            //    'label' => "Image :",
            //    'data_class' => null,
            //    'required'=> false
            //])
            ->add('XS', IntegerType::class, [
                'attr' => ['class' => 'form-control'],
                'label' => "Stock XS :"
            ])
            ->add('S', IntegerType::class, [
                'attr' => ['class' => 'form-control'],
                'label' => "Stock S :"
            ])
            ->add('M', IntegerType::class, [
                'attr' => ['class' => 'form-control'],
                'label' => "Stock M :"
            ])
            ->add('L', IntegerType::class, [
                'attr' => ['class' => 'form-control'],
                'label' => "Stock L :"
            ])
            ->add('XL', IntegerType::class, [
                'attr' => ['class' => 'form-control'],
                'label' => "Stock XL :"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
