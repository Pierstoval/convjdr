<?php

namespace App\Controller\Admin;

use App\Entity;
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

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::section('Events');
        yield MenuItem::linkToCrud('Event', 'fas fa-list', Entity\Event::class);
        yield MenuItem::section('Venue configuration');
        yield MenuItem::linkToCrud('Event Venue', 'fas fa-list', Entity\Venue::class);
        yield MenuItem::linkToCrud(' Floor', 'fas fa-list', Entity\Floor::class);
        yield MenuItem::linkToCrud('  Room', 'fas fa-list', Entity\Room::class);
        yield MenuItem::linkToCrud('   Table', 'fas fa-list', Entity\Table::class);
        yield MenuItem::section('Activities');
        yield MenuItem::linkToCrud('Animation', 'fas fa-list', Entity\Animation::class);
        yield MenuItem::linkToCrud(' Scheduled Animation', 'fas fa-list', Entity\ScheduledAnimation::class);
        yield MenuItem::linkToCrud('Time Slot', 'fas fa-list', Entity\TimeSlot::class);
        yield MenuItem::linkToCrud(' Time Slot Category', 'fas fa-list', Entity\TimeSlotCategory::class);
        yield MenuItem::linkToCrud('Attendee', 'fas fa-list', Entity\Attendee::class);
    }
}
