<?php
/**
 * Contact controller.
 */

namespace App\Controller;

use App\Entity\Contact;
use App\Repository\ContactRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ContactController.
 *
 * @Route("/contact")
 */
class ContactController extends AbstractController
{
    /**
     * Index action.
     *
     * @param \App\Repository\ContactRepository $contactRepository Contact repository
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @Route(
     *     "/",
     *     methods={"GET"},
     *     name="contact_index",
     * )
     */
    public function index(ContactRepository $contactRepository): Response
    {
        return $this->render(
            'contact/index.html.twig',
            ['contacts' => $contactRepository->findAll()]
        );
    }

    /**
     * Show action.
     *
     * @param \App\Entity\Contact $contact Contact entity
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @Route(
     *     "/{id}",
     *     methods={"GET"},
     *     name="contact_show",
     *     requirements={"id": "[1-9]\d*"},
     * )
     */
    public function show(Contact $contact): Response
    {
        return $this->render(
            'contact/show.html.twig',
            ['contact' => $contact]
        );
    }
}
