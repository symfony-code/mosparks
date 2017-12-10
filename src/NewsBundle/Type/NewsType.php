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
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class NewsType
 * @package NewsBundle\Type
 */
class NewsType extends AbstractType
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
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
            $image = new File($this->container->getParameter('news_upload_image') . '/' . $news->getImage());
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