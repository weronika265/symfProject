<?php
/**
 * UserData controller.
 */

namespace App\Controller;

use App\Entity\UserData;
use App\Form\UserDataType;
use App\Repository\UserDataRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class UserDataDataController.
 */
class UserDataController extends AbstractController
{
    /**
     * Create action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request            HTTP request
     * @param \App\Repository\UserDataRepository        $userDataRepository UserDataRepository
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route(
     *     "/create",
     *     methods={"GET", "POST"},
     *     name="user_data_create",
     * )
     */
    public function create(Request $request, UserDataRepository $userDataRepository): Response
    {
        $userData = new UserData();
        $form = $this->createForm(UserDataType::class, $userData);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userData->setAuthor($this->getUser());
            $userDataRepository->save($userData);
            $this->addFlash('success', 'message_created_successfully');

            return $this->redirectToRoute('user_index');
        }

        return $this->render(
            'userData/create.html.twig',
            ['form' => $form->createView()]
        );
    }

    /**
     * Edit action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request  HTTP request
     * @param \App\Entity\UserData                      $userData UserData entity
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route(
     *     "/{id}/edit",
     *     methods={"GET", "PUT"},
     *     requirements={"id": "[1-9]\d*"},
     *     name="user_data_edit",
     * )
     */
    public function edit(Request $request, UserData $userData): Response
    {
        $form = $this->createForm(UserDataType::class, $userData, ['method' => 'PUT']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->UserService->save($userData);
            $this->addFlash('success', 'message_updated_successfully');

            return $this->redirectToRoute('user_index');    /* TODO: make different for userData edit and admin edit. */
        }

        return $this->render(
            'userData/edit.html.twig',
            [
                'form' => $form->createView(),
                'userData' => $userData,
            ]
        );
    }

    /**
     * Delete action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request            HTTP request
     * @param \App\Entity\UserData                      $userData           UserData entity
     * @param \App\Repository\UserDataRepository        $userDataRepository UserData repository
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route(
     *     "/{id}/delete",
     *     methods={"GET", "DELETE"},
     *     requirements={"id": "[1-9]\d*"},
     *     name="user_data_delete",
     * )
     */
    public function delete(Request $request, UserData $userData, UserDataRepository $userDataRepository): Response
    {
        $form = $this->createForm(FormType::class, $userData, ['method' => 'DELETE']);
        $form->handleRequest($request);

        if ($request->isMethod('DELETE') && !$form->isSubmitted()) {
            $form->submit($request->request->get($form->getName()));
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $userDataRepository->delete($userData);
            $this->addFlash('success', 'message_deleted_successfully');

            return $this->redirectToRoute('user_index');
        }

        return $this->render(
            'userData/delete.html.twig',
            [
                'form' => $form->createView(),
                'userData' => $userData,
            ]
        );
    }
}
