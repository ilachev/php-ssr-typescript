<?php

declare(strict_types=1);

namespace App\Model\Market\UseCase\Categories\Category\Create;

use App\ReadModel\Market\Categories\Category\CategoryFetcher;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class Form extends AbstractType
{
    private CategoryFetcher $categories;

    public function __construct(CategoryFetcher $categories)
    {
        $this->categories = $categories;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $categories = [];
        foreach ($this->categories->allList() as $key => $item) {
            $categories[$item] = $key;
        }

        $builder
            ->add('name', Type\TextType::class, ['label' => 'Название'])
            ->add('description', CKEditorType::class, [
                'label' => 'Описание',
                'required' => false,
            ])
            ->add('parent', Type\ChoiceType::class, [
                'label' => 'Родительская категория',
                'required' => false,
                'choices' => $categories,
            ])
            ->add('sort', Type\IntegerType::class, [
                'label' => 'Сортировка',
                'required' => false,
                'data' => 0,
            ])
            ->add('metaTitle', Type\TextType::class, [
                'label' => 'Meta Title',
                'required' => false,
            ])
            ->add('metaDescription', Type\TextType::class, [
                'label' => 'Meta Description',
                'required' => false,
            ])
            ->add('metaOgTitle', Type\TextType::class, [
                'label' => 'Meta OG Title',
                'required' => false,
            ])
            ->add('metaOgDescription', Type\TextType::class, [
                'label' => 'Meta Og Description',
                'required' => false,
            ])
            ->add('seoHeading', Type\TextType::class, [
                'label' => 'Seo H1',
                'required' => false,
            ])
            ->add('seoDescription', Type\TextType::class, [
                'label' => 'Seo Description',
                'required' => false,
            ])
            ->add('logo', Type\FileType::class, [
                'label' => 'Логотип',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'mimeTypes' => [
                            'image/png',
                            'image/jpg',
                            'image/jpeg',
                        ],
                        'mimeTypesMessage' => 'Файл должен быть в формате jpeg, png',
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Command::class,
        ]);
    }
}
