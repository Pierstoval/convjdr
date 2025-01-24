<?php

namespace App\Controller\Admin;

use App\Entity\ScheduledAnimation;
use App\Entity\TimeSlot;
use App\Repository\EventRepository;
use App\Repository\ScheduledAnimationRepository;
use App\Repository\TimeSlotRepository;
use App\Repository\VenueRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Option\EA;
use EasyCorp\Bundle\EasyAdminBundle\Provider\AdminContextProvider;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

/**
 * @see DashboardController::calendar
 */
class CalendarController extends AbstractController
{
    public function __construct(
        private readonly EventRepository $eventRepository,
        private readonly TimeSlotRepository $timeSlotRepository,
        private readonly ScheduledAnimationRepository $scheduledAnimationRepository,
        private readonly VenueRepository $venueRepository,
        private readonly AdminContextProvider $adminContextProvider,
    ) {
    }

    #[Route('/admin/calendar', name: 'admin_calendar', defaults: [EA::DASHBOARD_CONTROLLER_FQCN => DashboardController::class])]
    public function __invoke(Request $request): Response
    {
        $this->adminContextProvider->getContext();

        if ($request->query->has('event')) {
            return $this->viewCalendar($request);
        }

        $events = $this->eventRepository->findAll();

        return $this->render('admin/calendar/choose_event.html.twig', [
            'events' => $events,
        ]);
    }

    private function viewCalendar(Request $request): Response
    {
        $eventId = $request->query->get('event');

        $event = $this->eventRepository->find($eventId);

        if (!$event) {
            $this->addFlash('warning', 'Event not found.');

            return $this->redirectToRoute('admin_calendar');
        }

        $venue = $this->venueRepository->findWithRelations($event->getVenue()->getId());
        $timeSlots = $this->timeSlotRepository->findForEvent($event);
        $scheduledAnimations = $this->scheduledAnimationRepository->findForEvent($event);
        $hours = $this->getHours($timeSlots);

        return $this->render('admin/calendar/view_event.html.twig', [
            'hours' => $hours,
            'time_slots' => $timeSlots,
            'scheduled_animations' => $scheduledAnimations,
            'event' => $event,
        ]);
    }

    /**
     * @param array<TimeSlot> $scheduledAnimations
     * @return array<int>
     */
    private function getHours(array $timeSlots): array
    {
        $hours = [];

        foreach ($timeSlots as $timeSlot) {
            $startHour = $timeSlot->getStartsAt()->format('H');
            $hours[] = $startHour;
        }

        $hours = \array_unique($hours);
        \sort($hours);

        return $hours;
    }
}
