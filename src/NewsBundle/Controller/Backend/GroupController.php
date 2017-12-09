<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 08.12.17
 * Time: 18:56
 */

namespace NewsBundle\Controller\Backend;

use Symfony\Component\Routing\Annotation\Route;
use NewsBundle\Entity\Group;
use NewsBundle\Type\GroupType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class GroupController extends Controller
{
    /**
     * @Route("/news/group", name="newsGroupIndex");
     */
    public function indexAction()
    {
        $groupRepository = $this->getDoctrine()->getRepository(Group::class);
        $models = $groupRepository->findAll();

        return $this->render(
            'news/backend/group/index.html.twig',
            [
                'models' => $models,
            ]
        );
    }

    /**
     * @Route("/news/group/create", name="newsGroupCreate")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createAction(
        Request $request
    )
    {
        $model = new Group();
        $entityManager = $this->getDoctrine()->getManager();

        $form = $this->createForm(GroupType::class, $model, ['label' => 'Создать']);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $model = $form->getData();
            $entityManager->persist($model);
            $entityManager->flush();
            $this->addFlash('success', 'Success');
            return new RedirectResponse($this->generateUrl('newsGroupView', ['id' => $model->getId()]));
        }

        return $this->render(
            'news/backend/group/create.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * @Route("/news/group/view/{id}", name="newsGroupView",requirements={"id": "\d+"})
     * @param $id
     * @return Response
     */
    public function viewAction(int $id)
    {
        $model = $this->find($id);

        return $this->render('news/backend/group/view.html.twig', ['model' => $model]);
    }

    /**
     * @Route("/news/group/update/{id}", name="newsGroupUpdate", requirements={"id": "\d+"})
     * @param int $id
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function updateAction(int $id, Request $request)
    {


        $model = $this->find($id);

        $form = $this->createForm(GroupType::class, $model, ['label' => 'Редактировать']);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();
            $this->addFlash('success', 'Success');
            return new RedirectResponse($this->generateUrl('newsGroupView', ['id' => $model->getId()]));
        }

        return $this->render('news/backend/group/update.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/news/group/delete/{id}", name="newsGroupDelete", requirements={"id": "\d+"})
     * @param $id
     * @return RedirectResponse
     */
    public function deleteAction(int $id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $model = $this->find($id);
        $entityManager->remove($model);
        $entityManager->flush();
        $this->addFlash('success', 'Success');
        return new RedirectResponse($this->generateUrl('newsGroupIndex'));
    }

    public function find(int $id)
    {
        $repository = $this->getDoctrine()->getRepository(Group::class);

        $model = $repository->find($id);

        if (is_null($model)) {
            throw $this->createNotFoundException('Not Found');
        }

        return $model;
    }
}