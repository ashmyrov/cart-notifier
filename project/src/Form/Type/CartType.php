<?php


namespace App\Form\Type;

use App\Entity\Cart;
use App\Entity\Customer;
use App\Entity\Product;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotNull;

class CartType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'customer',
                EntityType::class,
                [
                    'class' => Customer::class,
                    'constraints' => [
                        new NotNull(),
                    ],
                ]
            )
            ->add(
                'products',
                EntityType::class,
                [
                    'class' => Product::class,
                    'multiple' => true,
                ]
            )
            ->add(
                'create_at',
                DateTimeType::class,
                [
                    'widget' => 'single_text',
                    'empty_data' => date('Y-m-d H:i:s'),
                    'constraints' => [
                        new NotNull(),
                    ]
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cart::class,
        ]);
    }
}
