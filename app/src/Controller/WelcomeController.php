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
            // TODO Change (name/origin of?) loaded resource, so it's naming is consistent with website nav.
        );
    }
}
