<?php

declare(strict_types=1);

namespace App\ReadModel\Market\Stores\Comments\Filter;

use App\Model\Market\Entity\Stores\Store\Comment\Status;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Form extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('slug', Type\TextType::class, ['required' => false, 'attr' => [
                'placeholder' => 'Магазин',
                'onchange' => 'this.form.submit()',
            ]])
            ->add('status', Type\ChoiceType::class, ['choices' => [
                'Черновик' => Status::DRAFT,
                'Подтверждён' => Status::APPROVED,
                'Отклонён' => Status::DECLINED,
            ], 'required' => false, 'placeholder' => 'Все статусы', 'attr' => ['onchange' => 'this.form.submit()']])
        ;
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
