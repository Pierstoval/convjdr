<?php

namespace App\Controller\Admin;

use App\Entity\TimeSlot;
use App\Repository\TimeSlotRepository;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class TimeSlotCrudController extends AbstractCrudController
{
    use GenericCrudMethods;

    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly TimeSlotRepository $scheduledAnimationRepository,
        private readonly TranslatorInterface $translator,
        private readonly CsrfTokenManagerInterface $csrfTokenManager,
    ) {
    }

    #[Route("/admin/scheduled-animation/accept/{id}", name: "admin_scheduled_animation_accept", methods: ['POST'])]
    public function createFromCalendar(Request $request): Response
    {
        $csrfToken = $request->request->get('_csrf');
        if (!$csrfToken || !$this->csrfTokenManager->isTokenValid($this->csrfTokenManager->getToken($csrfToken))) {
            throw new BadRequestHttpException('Invalid CSRF token.');
        }

        $start = $request->request->get('start');
        $end = $request->request->get('end');
        $table = $request->request->get('table');

    }

    public static function getEntityFqcn(): string
    {
        return TimeSlot::class;
    }

    //

    public function configureFields(string $pageName): iterable
    {
        yield Field\AssociationField::new('event')->setRequired(true);
        yield Field\AssociationField::new('table')->setRequired(true);
        yield Field\AssociationField::new('category')->setRequired(true)->setHelp('Mostly informational');
        yield Field\DateTimeField::new('startsAt')->setTimezone('UTC');
        yield Field\DateTimeField::new('endsAt')->setTimezone('UTC');
    }
}
