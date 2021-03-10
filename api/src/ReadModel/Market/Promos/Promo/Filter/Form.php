<?php

declare(strict_types=1);

namespace App\ReadModel\Market\Promos\Promo\Filter;

use App\Model\Market\Entity\Promos\Promo\Status;
use App\Model\Market\Entity\Promos\Promo\Type as PromoType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Form extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', Type\TextType::class, ['required' => false, 'attr' => [
                'placeholder' => 'Название',
                'onchange' => 'this.form.submit()',
            ]])
            ->add('store', Type\TextType::class, ['required' => false, 'attr' => [
                'placeholder' => 'Магазин',
                'onchange' => 'this.form.submit()',
            ]])
            ->add('type', Type\ChoiceType::class, ['choices' => [
                'Купон' => PromoType::COUPON,
                'Скидка' => PromoType::DISCOUNT,
                'Промо-код' => PromoType::PROMO_CODE,
            ], 'placeholder' => 'Все типы', 'attr' => ['onchange' => 'this.form.submit()'], 'required' => false])
            ->add('status', Type\ChoiceType::class, ['choices' => [
                'Active' => Status::ACTIVE,
                'Archived' => Status::ARCHIVED,
            ], 'required' => false, 'placeholder' => 'Все статусы', 'attr' => ['onchange' => 'this.form.submit()']]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Filter::class,
            'method' => 'GET',
            'csrf_protection' => false,
        ]);
    }
}
