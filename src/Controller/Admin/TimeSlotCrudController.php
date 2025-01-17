<?php

namespace App\Controller\Admin;

use App\Entity\TimeSlot;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field;

class TimeSlotCrudController extends AbstractCrudController
{
    use GenericCrudMethods;

    public static function getEntityFqcn(): string
    {
        return TimeSlot::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield Field\FormField::addColumn(12);
        yield Field\AssociationField::new('event')->setRequired(true);
        yield Field\AssociationField::new('category')->setRequired(true);
        yield Field\AssociationField::new('table')->setRequired(true);
        yield Field\FormField::addColumn(6);
        yield Field\DateTimeField::new('startsAt');
        yield Field\FormField::addColumn(6);
        yield Field\DateTimeField::new('endsAt');
    }
}
