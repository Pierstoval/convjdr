<?php

namespace App\Controller\Admin;

use App\Entity\Room;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field;

class RoomCrudController extends AbstractCrudController
{
    use GenericCrudMethods;

    public static function getEntityFqcn(): string
    {
        return Room::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            Field\TextField::new('name', 'Room name'),
            Field\AssociationField::new('floor')->setDisabled($pageName === Crud::PAGE_EDIT),
            Field\CollectionField::new('tables')->useEntryCrudForm(TableCrudController::class),
        ];
    }
}
