<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 10.12.17
 * Time: 16:26
 */

namespace NewsBundle\Service;


use NewsBundle\Entity\News;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class NewsImageService
 * @package NewsBundle\Service
 */
class NewsImageService
{

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * NewsImageService constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }


    /**
     * @param News $model
     */
    public function upload(News $model)
    {
        $image = $model->getImage();

        $name = md5(uniqid()) . '.' . $image->guessExtension();
        $image->move(
            $this->container->getParameter('news_upload_image'),
            $name
        );
        $model->setImage($name);
    }
}