<?php
/**
 * Created by PhpStorm.
 * User: cherem
 * Date: 29.11.17
 * Time: 13:28
 */

namespace NewsBundle\Type;


use NewsBundle\Help\NewsHelp;
use NewsBundle\Transformer\GroupTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class NewsType
 * @package NewsBundle\Type
 */
class NewsType extends AbstractType
{
    /**
     * @var GroupTransformer
     */
    private $groupTransformer;

    /**
     * NewsType constructor.
     * @param GroupTransformer $groupTransformer
     */
    public function __construct(GroupTransformer $groupTransformer)
    {

        $this->groupTransformer = $groupTransformer;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if (is_null($options['label'])) {
            throw new \RuntimeException('Configuration error of form');
        }

        $builder
            ->add('title', TextType::class)
            ->add('announce', TextareaType::class)
            ->add('text', TextareaType::class)
            ->add('group', TextType::class)
            ->add('hidden', ChoiceType::class, ['choices' => NewsHelp::getHiddenDropDown()])
            ->add('save', SubmitType::class, ['label' => $options['label']]);

        $builder->get('group')->addModelTransformer($this->groupTransformer);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'label' => null,
        ]);
    }


}