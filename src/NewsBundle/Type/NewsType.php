<?php
/**
 * Created by PhpStorm.
 * User: cherem
 * Date: 29.11.17
 * Time: 13:28
 */

namespace NewsBundle\Type;


use NewsBundle\Help\NewsHelp;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class NewsType
 * @package NewsBundle\Type
 */
class NewsType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class)
            ->add('announce', TextareaType::class)
            ->add('text', TextareaType::class)
            ->add('hidden', ChoiceType::class, ['choices' => NewsHelp::getHiddenDropDown()])
            ->add('save', SubmitType::class, ['label' => 'Создать']);
    }

}