<?php

namespace App\Controller\Admin;

use App\Entity;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Convjdr')
        ;
    }

    public function configureAssets(): Assets
    {
        return parent::configureAssets()->addCssFile('styles/admin-nested-forms.css');
    }

    public function configureMenuItems(): iterable
    {
        $events = MenuItem::linkToCrud('Events', 'fas fa-list', Entity\Event::class);

        $venueConfigSection = MenuItem::section('Venue configurations');
        $venue = MenuItem::linkToCrud('Event Venues', 'fas fa-list', Entity\Venue::class);
        $floor = MenuItem::linkToCrud('├─ Floor', 'fas fa-list', Entity\Floor::class)->setController(FloorCrudController::class);
        $room = MenuItem::linkToCrud('├── Room', 'fas fa-list', Entity\Room::class);
        $table = MenuItem::linkToCrud('└─── Table', 'fas fa-list', Entity\Table::class);

        $activitiesSection = MenuItem::section('Activities');
        $animation = MenuItem::linkToCrud('Animations', 'fas fa-list', Entity\Animation::class);
        $scheduledAnimation = MenuItem::linkToCrud('└─ Scheduled Animations', 'fas fa-list', Entity\ScheduledAnimation::class);
        $timeSlot = MenuItem::linkToCrud('Time Slots', 'fas fa-list', Entity\TimeSlot::class);
        $timeSlotCategory = MenuItem::linkToCrud('└─ Time Slot Category', 'fas fa-list', Entity\TimeSlotCategory::class);

        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');

        if ($this->isGranted('ROLE_ADMIN')) {
            yield MenuItem::section('Administration');
        } else {
            yield MenuItem::section('Convention organisation');
        }

        yield $events;

        yield $venueConfigSection;
        yield $venue;
        yield $floor;
        yield $room;
        yield $table;

        yield $activitiesSection;
        yield $animation;
        yield $scheduledAnimation;
        yield $timeSlot;
        yield $timeSlotCategory;
    }
}
