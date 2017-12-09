<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 08.12.17
 * Time: 19:13
 */

namespace NewsBundle\Type;


use NewsBundle\Entity\Group;
use NewsBundle\Help\GroupHelper;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GroupType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if (is_null($options['label'])) {
            throw new \RuntimeException('Configuration error of Form');
        }

        $builder
            ->add('title', TextType::class)
            ->add('hidden', ChoiceType::class, ['choices' => GroupHelper::getHiddenDropDown()])
            ->add('save', SubmitType::class, ['label' => $options['label']]);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'label' => null,
            'data_class' => Group::class,
        ]);
    }
}