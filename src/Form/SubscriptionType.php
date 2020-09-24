<?php

declare(strict_types=1);

namespace App\Form;

use App\Dto\Subscriber;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataMapperInterface;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class SubscriptionType extends AbstractType implements DataMapperInterface
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->setAction($options['action'])
            ->add('name', TextType::class, [
                'attr' => [
                    'placeholder' => 'Name',
                ],
            ])
            ->add('email', EmailType::class, [
                'attr' => [
                    'placeholder' => 'Email',
                ],
            ])
            ->add('subscribe', SubmitType::class)
            ->setDataMapper($this);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Subscriber::class,
            'empty_data' => null,
        ]);
    }

    public function mapDataToForms($subscriberDto, $forms): void
    {
        $forms = iterator_to_array($forms);
        $forms['name']->setData($subscriberDto ? $subscriberDto->getName() : '');
        $forms['email']->setData($subscriberDto ? $subscriberDto->getPrice() : '');
    }

    public function mapFormsToData($forms, &$subscriberDto): void
    {
        $forms = iterator_to_array($forms);
        $subscriberDto = new Subscriber($forms['name']->getData(), $forms['email']->getData());
    }
}
