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
    #[Route('/admin', name: 'admin', methods: ['GET', 'POST', 'DELETE', 'PATCH', 'PUT'])]
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
        return parent::configureAssets()
            ->addCssFile('styles/admin.css')
            ->addAssetMapperEntry('admin')
        ;
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::section('Administration');
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');

        yield MenuItem::section('Convention organisation');
        yield MenuItem::linkToCrud('Events', 'fas fa-list', Entity\Event::class);
        yield MenuItem::linkToRoute('Calendar', 'fas fa-calendar', 'admin_calendar');

        yield MenuItem::section('Venue configurations');
        yield MenuItem::linkToCrud('Event Venues', 'fas fa-list', Entity\Venue::class);
        yield MenuItem::linkToCrud('├─ Floor', 'fas fa-list', Entity\Floor::class)->setController(FloorCrudController::class);
        yield MenuItem::linkToCrud('├── Room', 'fas fa-list', Entity\Room::class);
        yield MenuItem::linkToCrud('└─── Table', 'fas fa-list', Entity\Table::class);

        yield MenuItem::section('Activities');
        yield MenuItem::linkToCrud('Animations', 'fas fa-list', Entity\Animation::class);
        yield MenuItem::linkToCrud('└─ Scheduled Animations', 'fas fa-list', Entity\ScheduledAnimation::class);
        yield MenuItem::linkToCrud('Time Slots', 'fas fa-list', Entity\TimeSlot::class);
        yield MenuItem::linkToCrud('└─ Time Slot Category', 'fas fa-list', Entity\TimeSlotCategory::class)->setPermission('ROLE_ADMIN');
    }
}
