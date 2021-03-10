<?php

declare(strict_types=1);

namespace App\Model\Market\UseCase\Stores\Setting\Edit;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Form extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('templateMetaTitle', Type\TextType::class, [
                'label' => 'Meta Title',
                'required' => false,
            ])
            ->add('templateMetaDescription', Type\TextType::class, [
                'label' => 'Meta Description',
                'required' => false,
            ])
            ->add('templateMetaOgTitle', Type\TextType::class, [
                'label' => 'Meta OG Title',
                'required' => false,
            ])
            ->add('templateMetaOgDescription', Type\TextType::class, [
                'label' => 'Meta OG Description',
                'required' => false,
            ])
            ->add('templateSeoHeading', Type\TextType::class, [
                'label' => 'Seo H1',
                'required' => false,
            ])
            ->add('templateSeoDescription', Type\TextType::class, [
                'label' => 'Seo Description',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Command::class,
        ]);
    }
}
