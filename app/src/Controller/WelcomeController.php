<?php
/**
 * Welcome controller.
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class WelcomeController.
 *
 * @Route("/personal_info")
 */
class WelcomeController extends AbstractController
{
    /**
     * Index action.
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @Route(
     *     "/",
     *     methods={"GET"},
     *     name="personal_info_index"
     * )
     */
    public function index(): Response
    {
        return $this->render(
            'personal_info/index.html.twig'
        );
    }

    /**
     * Show contacts action.
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @Route(
     *     "/contacts",
     *     methods={"GET"},
     *     name="personal_info_contacts"
     * )
     */
    public function showContacts(): Response
    {
        return $this->render(
            'personal_info/contacts.html.twig'
        );
    }
}
