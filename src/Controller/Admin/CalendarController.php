<?php

namespace App\Controller\Admin;

use App\Entity\Animation;
use App\Entity\Event;
use App\Entity\ScheduledAnimation;
use App\Entity\TimeSlot;
use App\Enum\ScheduleAnimationState;
use App\Repository\EventRepository;
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
        private readonly AdminContextProvider $adminContextProvider,
    ) {
    }

    #[Route('/admin/calendar', name: 'admin_calendar', defaults: [EA::DASHBOARD_CONTROLLER_FQCN => DashboardController::class])]
    public function calendarIndex(Request $request): Response
    {
        $this->adminContextProvider->getContext();

        $events = $this->eventRepository->findUpcoming();

        if ($request->query->has('event')) {
            return $this->viewCalendar($request, $events);
        }

        return $this->render('admin/calendar/calendar.html.twig', [
            'events' => $events,
        ]);
    }

    #[Route('/admin/calendar/{event_id}', name: 'admin_calendar_event', defaults: [EA::DASHBOARD_CONTROLLER_FQCN => DashboardController::class])]
    public function viewCalendar(Request $request, string $event_id): Response
    {
        $event = $this->eventRepository->findForCalendar($event_id);

        if (!$event) {
            $this->addFlash('warning', 'Event not found.');

            return $this->redirectToRoute('admin_calendar');
        }

        if ($request->query->has('filter_state') && !empty($filters = $request->query->all()['filter_state'])) {
            if (!\is_array($filters)) {
                $filters = explode(',', $filters);
            }
            $stateStrings = \array_map('trim', $filters);
            $states = \array_map(static fn (string $stateStr) => ScheduleAnimationState::from($stateStr), $stateStrings);
        } else {
            $states = [
                //ScheduleAnimationState::CREATED,
                ScheduleAnimationState::PENDING_REVIEW,
                ScheduleAnimationState::REFUSED,
                ScheduleAnimationState::ACCEPTED,
            ];
        }

        $timeSlots = $event->getTimeSlots();
        $hours = $this->getHours($timeSlots);
        $events = $this->eventRepository->findUpcoming(); // For choices

        // Calendar js data
        $jsonResources = $event->getCalendarResourceJson();
        $jsonSchedules = $event->getCalendarSchedulesJson();

        return $this->render('admin/calendar/calendar_event.html.twig', [
            'events' => $events,
            'hours' => $hours,
            'event' => $event,
            'json_resources' => $jsonResources,
            'json_schedules' => $jsonSchedules,
            'filter_states' => \array_map(static fn (ScheduleAnimationState $state) => $state->value, $states),
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
