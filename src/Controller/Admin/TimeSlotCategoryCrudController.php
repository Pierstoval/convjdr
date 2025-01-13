<?php

namespace App\Controller\Admin;

use App\Entity\TimeSlotCategory;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class TimeSlotCategoryCrudController extends AbstractCrudController
{
    use GenericCrudMethods;

    public static function getEntityFqcn(): string
    {
        return TimeSlotCategory::class;
    }
}
