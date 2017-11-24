<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 24.11.17
 * Time: 16:56
 */

namespace NewsBundle\Backend\Controller;

use NewsBundle\Entity\News;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class NewsController
 * @package NewsBundle\Controllers
 */
class NewsController extends Controller
{
    /**
     * @Route("/news", name="NewsIndex");
     * @return Response
     */
    public function indexAction()
    {
        $manager = $this->getDoctrine()->getManager();
        $news = new News();
        $news->setTitle('test')
            ->setAnnounce('test')
            ->setText('test')
            ->setHidden(false)
            ->setCreatedAt(new \DateTime())
            ->setUpdatedAt(new \DateTime());

        $manager->persist($news);
        $manager->flush();

        return new Response('Success');
    }
}