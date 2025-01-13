<?php

namespace App\Controller\Admin;

use App\Entity\TimeSlot;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class TimeSlotCrudController extends AbstractCrudController
{
    use GenericCrudMethods;

    public static function getEntityFqcn(): string
    {
        return TimeSlot::class;
    }
}
