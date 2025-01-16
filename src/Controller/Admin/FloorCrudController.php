<?php

namespace App\Controller\Admin;

use App\Entity\Floor;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field;

class FloorCrudController extends AbstractCrudController
{
    use GenericCrudMethods;

    public static function getEntityFqcn(): string
    {
        return Floor::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            Field\TextField::new('name', 'Floor name'),
            Field\CollectionField::new('rooms')->useEntryCrudForm(RoomCrudController::class),
        ];
    }
}
