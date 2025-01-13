<?php

namespace App\Controller\Admin;

use App\Entity\Venue;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field;

class EventVenueCrudController extends AbstractCrudController
{
    use GenericCrudMethods;

    public static function getEntityFqcn(): string
    {
        return Venue::class;
    }

    public function configureFields(string $pageName): iterable
    {
        if (Crud::PAGE_INDEX === $pageName) {
            return [
                Field\IdField::new('id'),
                Field\TextField::new('name'),
                Field\TextEditorField::new('address'),
            ];
        }

        if (Crud::PAGE_NEW === $pageName) {
            return [
                Field\TextField::new('name'),
                Field\TextEditorField::new('address'),
                Field\CollectionField::new('floors'),
            ];
        }

        return [];
    }
}
