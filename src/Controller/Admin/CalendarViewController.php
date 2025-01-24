<?php

namespace App\Controller\Admin;

use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CalendarViewController extends AbstractController
{
    public function __construct(
        private readonly EventRepository $eventRepository
    ) {
    }

    public function __invoke(Request $request): Response
    {
        if ($request->query->has('event_id')) {
            return $this->viewCalendar($request);
        }

        return $this->render('admin/calendar/choose_event.html.twig');
    }

    private function viewCalendar(Request $request): Response
    {
        $eventId = $request->query->get('event_id');

        $event = $this->eventRepository->find($eventId);

        if (!$event) {

        }
    }
}
