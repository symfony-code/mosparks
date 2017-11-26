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
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class NewsController
 * @package NewsBundle\Controllers
 */
class NewsController extends Controller
{
    /**
     * @Route("/news", name="newsIndex");
     * @return Response
     */
    public function indexAction()
    {

        $doctrine = $this->getDoctrine();
        $newRepository = $doctrine->getRepository(News::class);

        $models = $newRepository->findAll();


        return $this->render('news/news/index.html.twig', ['models' => $models]);
    }

    /**
     * @Route("/news/create", name="newsCreate")
     *
     * @return Response
     */
    public function createAction(Request $request)
    {
        $news = new News();
        $news->setHidden(0)->setCreatedAt(new \DateTime())->setUpdatedAt(new \DateTime());
        $form = $this->createFormBuilder($news)
            ->add('title', TextType::class)
            ->add('announce', TextareaType::class)
            ->add('text', TextareaType::class)
            ->add('save', SubmitType::class, array('label' => 'Создать'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $news = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($news);
            $entityManager->flush();
        }

        return $this->render('news/news/create.html.twig', ['form' => $form->createView()]);
    }
}