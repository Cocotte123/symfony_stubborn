<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class StockSizeFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', ChoiceType::class, [
                'choices'  => [
                    '10 à 29€' => 1,
                    '30 à 35€' => 2,
                    '36 à 50€' => 3,
                    '' => 4
                ],
            ]);
            
    }

   
}
