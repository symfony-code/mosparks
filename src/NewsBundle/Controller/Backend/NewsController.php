<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 24.11.17
 * Time: 16:56
 */

namespace NewsBundle\Controller\Backend;

use NewsBundle\Service\NewsImageService;
use Symfony\Component\Routing\Annotation\Route;
use NewsBundle\Entity\News;
use NewsBundle\Type\NewsType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


/**
 * Class NewsController
 * @package NewsBundle\Controllers
 */
class NewsController extends Controller
{
    /**
     * @var NewsImageService
     */
    private $newsImageService;

    public function __construct(NewsImageService $newsImageService)
    {
        $this->newsImageService = $newsImageService;
    }

    /**
     * @Route("/news", name="newsIndex");
     * @return Response
     */
    public function indexAction()
    {

        $doctrine = $this->getDoctrine();
        $newRepository = $doctrine->getRepository(News::class);

        $models = $newRepository->findAll();

        return $this->render('news/backend/news/index.html.twig', ['models' => $models]);
    }

    /**
     * @Route("/news/create", name="newsCreate")
     *
     * @return Response
     */
    public function createAction(Request $request)
    {
        $model = new News();

        $form = $this->createForm(NewsType::class, $model, ['label' => 'Создать']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->newsImageService->upload($model);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($model);
            $entityManager->flush();
            $this->addFlash('success', 'Success');

            return new RedirectResponse($this->generateUrl('newsView', ['id' => $model->getId()]));
        }

        return $this->render('news/backend/news/create.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/news/view/{id}", name="newsView", requirements={"id": "\d+"})
     * @param $id
     * @return Response
     */
    public function viewAction(int $id)
    {
        $model = $this->find($id);
        return $this->render('news/backend/news/view.html.twig', ['model' => $model]);
    }

    /**
     * @Route("/news/update/{id}", name="newsUpdate", requirements={"id": "\d+"})
     * @param int $id
     * @param Request $request
     * @return Response
     */
    public function updateAction(int $id, Request $request)
    {
        $model = $this->find($id);

        $form = $this->createForm(NewsType::class, $model, ['label' => 'Редактировать']);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->newsImageService->upload($model);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            $this->addFlash('success', 'Success');

            return new RedirectResponse($this->generateUrl('newsView', ['id' => $model->getId()]));
        }

        return $this->render('news/backend/news/update.html.twig', ['form' => $form->createView()]);
    }


    /**
     * @Route("news/delete/{id}", name="newsDelete", requirements={"id": "\d+"})
     * @param $id
     * @return RedirectResponse
     */
    public function deleteAction(int $id)
    {
        $model = $this->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($model);
        $entityManager->flush();
        $this->addFlash('success', 'Success');
        return new RedirectResponse($this->generateUrl('newsIndex'));
    }

    /**
     * @param $id
     * @return News|object
     */
    public function find(int $id): News
    {
        $repository = $this->getDoctrine()->getRepository(News::class);
        $model = $repository->find($id);
        $this->notFoundException($model);
        return $model;
    }

    /**
     * @param News|null $model
     */
    public function notFoundException(News $model = null)
    {
        if (is_null($model)) {
            throw $this->createNotFoundException('Not found');
        }
    }
}