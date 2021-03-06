<?php
/**
 * Created by PhpStorm.
 * User: cherem
 * Date: 29.11.17
 * Time: 13:28
 */

namespace NewsBundle\Type;


use NewsBundle\Entity\Group;
use NewsBundle\Entity\News;
use NewsBundle\Help\NewsHelp;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class NewsType
 * @package NewsBundle\Type
 */
class NewsType extends AbstractType
{
    /**
     * @var string
     */
    private $dir;

    public function __construct(string $dir)
    {
        $this->dir = $dir;
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

        $image = '';

        /** @var News $news */
        $news = $options['data'];

        if (!is_null($news->getId()) && !empty($news->getImage())) {
            $image = new File($this->dir . '/' . $news->getImage());
        }

        $builder
            ->add('image', FileType::class, ['data' => $image])
            ->add('title', TextType::class)
            ->add('announce', TextareaType::class)
            ->add('text', TextareaType::class)
            ->add('group', EntityType::class, [
                'class' => Group::class,
                'choice_label' => 'title',
                'placeholder' => 'Choose an option',
                'required' => false,
            ])
            ->add('hidden', ChoiceType::class, ['choices' => NewsHelp::getHiddenDropDown()])
            ->add('save', SubmitType::class, ['label' => $options['label']]);
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        /** @var News $news */
        $news = $form->getData();

        if (!is_null($news->getId()) && !empty($news->getImage())) {
            $view->vars['imageName'] = $news->getImage();
        }
    }


    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'label' => null,
            'data_class' => News::class,
        ]);
    }
}