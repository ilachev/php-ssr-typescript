<?php

declare(strict_types=1);

namespace App\Model\Market\UseCase\Promos\Promo\Edit;

use App\Model\Market\Entity\Promos\Promo\DiscountUnit;
use App\Model\Market\Entity\Promos\Promo\Type as PromoType;
use App\ReadModel\Market\Stores\Store\StoreFetcher;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Form extends AbstractType
{
    private StoreFetcher $stores;

    public function __construct(StoreFetcher $stores)
    {
        $this->stores = $stores;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $stores = [];
        foreach ($this->stores->allList() as $key => $item) {
            $stores[$item] = $key;
        }

        $builder
            ->add('name', Type\TextType::class, ['label' => 'Название'])
            ->add('type', Type\ChoiceType::class, [
                'label' => 'Тип',
                'required' => true,
                'choices' => [
                    'Купон' => PromoType::COUPON,
                    'Скидка' => PromoType::DISCOUNT,
                    'Промо-код' => PromoType::PROMO_CODE,
                ],
            ])
            ->add('code', Type\TextType::class, [
                'label' => 'Код',
                'required' => false,
            ])
            ->add('referralLink', Type\UrlType::class, [
                'label' => 'Реферальная ссылка',
                'required' => true,
            ])
            ->add('discount', Type\IntegerType::class, [
                'label' => 'Скидка',
                'required' => false,
            ])
            ->add('discountUnit', Type\ChoiceType::class, [
                'label' => 'Единица скидки',
                'required' => false,
                'choices' => [
                    'процент' => DiscountUnit::PERCENT,
                    'рубль' => DiscountUnit::RUBLE,
                    'доллар' => DiscountUnit::DOLLAR,
                    'евро' => DiscountUnit::EURO,
                ],
            ])
            ->add('startDate', Type\DateType::class, [
                'label' => 'Дата начала',
                'required' => true,
                'input' => 'datetime_immutable',
            ])
            ->add('endDate', Type\DateType::class, [
                'label' => 'Дата окончания',
                'required' => true,
                'input' => 'datetime_immutable',
            ])
            ->add('store', Type\ChoiceType::class, [
                'label' => 'Магазин',
                'required' => true,
                'choices' => $stores,
            ])
            ->add('description', CKEditorType::class, [
                'label' => 'Описание',
                'required' => false,
            ])
            ->add('seoHeading', Type\TextType::class, [
                'label' => 'Seo H2',
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Command::class,
        ]);
    }
}
