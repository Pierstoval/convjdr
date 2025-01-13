<?php

namespace App\Controller\Admin;

use App\Entity\ScheduledAnimation;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ScheduledAnimationCrudController extends AbstractCrudController
{
    use GenericCrudMethods;

    public static function getEntityFqcn(): string
    {
        return ScheduledAnimation::class;
    }
}
