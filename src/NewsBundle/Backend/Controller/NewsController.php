<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 24.11.17
 * Time: 16:56
 */

namespace NewsBundle\Backend\Controller;

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

        return $this->render('news/news/index.html.twig');
    }
}