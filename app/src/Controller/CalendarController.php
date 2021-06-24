<?php
/**
 * Calendar controller.
 */

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventType;
use App\Service\CalendarService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CalendarController.
 *
 * @Route("/calendar")
 */
class CalendarController extends AbstractController
{
    /**
     * Calendar service.
     */
    private CalendarService $calendarService;

    /**
     * CalendarController constructor.
     *
     * @param \App\Service\EventService $calendarService Calendar service
     */
    public function __construct(CalendarService $calendarService)
    {
        $this->calendarService = $calendarService;
    }

    /**
     * Index action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request HTTP request
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @Route(
     *     "/",
     *     name="calendar_index",
     * )
     */
    public function index(Request $request): Response
    {
        $filters = [];
        $filters['category_id'] = $request->query->getInt('filters_category_id');
        $filters['tag_id'] = $request->query->getInt('filters_tag_id');

        $pagination = $this->calendarService->createPaginatedList(
            $request->query->getInt('page', 1),
            $this->getUser(),
            $filters
        );

        return $this->render(
            'calendar/index.html.twig',
            ['pagination' => $pagination]
        );
    }

    /**
     * Show event action.
     *
     * @param \App\Entity\Event $event Event entity
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP Response
     *
     * @Route(
     *     "/{id}",
     *     methods={"GET"},
     *     name="calendar_show",
     *     requirements={"id": "[1-9]\d*"},
     * )
     *
     * @IsGranted(
     *     "VIEW",
     *     subject="event",
     * )
     */
    public function show(Event $event): Response
    {
        return $this->render(
            'calendar/show.html.twig',
            ['event' => $event]
        );
    }

    /**
     * Create action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request HTTP request
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route(
     *     "/create",
     *     methods={"GET", "POST"},
     *     name="calendar_create",
     * )
     */
    public function create(Request $request): Response
    {
        $event = new Event();
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->calendarService->save($event, $this->getUser());
            $this->addFlash('success', 'message_created_successfully');

            return $this->redirectToRoute('calendar_index');
        }

        return $this->render(
            'calendar/create.html.twig',
            ['form' => $form->createView()]
        );
    }

    /**
     * Edit action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request HTTP request
     * @param \App\Entity\Event                         $event   Event entity
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
     *     name="calendar_edit",
     * )
     *
     * @IsGranted(
     *     "EDIT",
     *     subject="event",
     * )
     */
    public function edit(Request $request, Event $event): Response
    {
        $form = $this->createForm(EventType::class, $event, ['method' => 'PUT']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->calendarService->save($event, $this->getUser());
            $this->addFlash('success', 'message_updated_successfully');

            return $this->redirectToRoute('calendar_index');
        }

        return $this->render(
            'calendar/edit.html.twig',
            [
                'form' => $form->createView(),
                'event' => $event,
            ]
        );
    }

    /**
     * Delete action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request HTTP request
     * @param \App\Entity\Event                         $event   Event entity
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
     *     name="calendar_delete",
     * )
     *
     * @IsGranted(
     *     "DELETE",
     *     subject="event",
     * )
     */
    public function delete(Request $request, Event $event): Response
    {
        $form = $this->createForm(FormType::class, $event, ['method' => 'DELETE']);
        $form->handleRequest($request);

        if ($request->isMethod('DELETE') && !$form->isSubmitted()) {
            $form->submit($request->request->get($form->getName()));
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $this->calendarService->delete($event);
            $this->addFlash('success', 'message_deleted_successfully');

            return $this->redirectToRoute('calendar_index');
        }

        return $this->render(
            'calendar/delete.html.twig',
            [
                'form' => $form->createView(),
                'event' => $event,
            ]
        );
    }
}
