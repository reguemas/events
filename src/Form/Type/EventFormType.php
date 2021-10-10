<?php

// src/Form/Type/EventFormType.php
namespace App\Form\Type;

use App\Form\Model\EventDto;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class)
            ->add('type', NumberType::class)
            ->add('beginDate', DateType::class, ['widget' => 'single_text', 'format' => 'Y-m-d H:i:s', 'html5' => false])
            ->add('endDate', DateType::class, ['widget' => 'single_text', 'format' => 'Y-m-d H:i:s', 'html5' => false])
            ->add('department', TextType::class)
            ->add('vocalia', TextType::class)
            ->add('modality', CollectionType::class, [
                'allow_add' => true,
                'allow_delete' => true,
                'entry_type' => ModalityFormType::class
            ])
            ->add('description', TextType::class)
            ->add('dificulty', NumberType::class)
            ->add('url', TextType::class)
            ->add('image', TextType::class)
            ->add('outsatnding', NumberType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => EventDto::class,
        ]);
    }

    public function getBlockPrefix()
    {
        return "";
    }

    public function getName()
    {
        return "";
    }
}
