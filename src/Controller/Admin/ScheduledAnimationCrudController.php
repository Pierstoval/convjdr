<?php

namespace App\Controller\Admin;

use App\Entity\ScheduledAnimation;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class ScheduledAnimationCrudController extends AbstractCrudController
{
    use GenericCrudMethods;

    public function __construct(
        private readonly TranslatorInterface $translator,
        private readonly CsrfTokenManagerInterface $csrfTokenManager,
    ) {
    }

    #[Route("/admin/scheduled-animation/accept/{entityId}", name: "admin_scheduled_animation_accept", methods: ['POST'])]
    public function acceptSchedule(Request $request)
    {
        $post = $request->request->all();
        dd($post);
    }

    #[Route("/admin/scheduled-animation/reject/{entityId}", name: "admin_scheduled_animation_reject", methods: ['POST'])]
    public function rejectSchedule(Request $request)
    {
        $post = $request->request->all();
        dd($post);
    }

    public static function getEntityFqcn(): string
    {
        return ScheduledAnimation::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        $actions->disable(Action::EDIT, Action::DELETE);

        return $actions;
    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        $qb = parent::createIndexQueryBuilder($searchDto, $entityDto, $fields, $filters);

        if ($this->isGranted('ROLE_ADMIN')) {
            return $qb;
        }

        $qb->innerJoin('entity.animation', 'animation')
            ->innerJoin('animation.creators', 'creators')
            ->andWhere('creators IN (:creator)')
            ->setParameter('creator', $this->getUser())
        ;

        return $qb;
    }

    public function configureFields(string $pageName): iterable
    {
        yield Field\TextField::new('stateString')->setDisabled()->hideWhenCreating();
        yield Field\AssociationField::new('animation')->setRequired(true);
        yield Field\AssociationField::new('timeSlot')->setRequired(true);
    }
}
