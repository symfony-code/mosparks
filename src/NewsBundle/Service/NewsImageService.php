<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 10.12.17
 * Time: 16:26
 */

namespace NewsBundle\Service;


use NewsBundle\Entity\News;

/**
 * Class NewsImageService
 * @package NewsBundle\Service
 */
class NewsImageService
{
    /**
     * @var string
     */
    private $dir;

    /**
     * NewsImageService constructor.
     * @param string $dir
     */
    public function __construct(string $dir)
    {
        $this->dir = $dir;
    }


    /**
     * @param News $model
     */
    public function upload(News $model)
    {
        $image = $model->getImage();

        $name = md5(uniqid()) . '.' . $image->guessExtension();
        $image->move(
            $this->dir,
            $name
        );

        $model->setImage($name);
    }
}