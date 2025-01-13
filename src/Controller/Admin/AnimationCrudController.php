<?php

namespace App\Controller\Admin;

use App\Entity\Animation;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class AnimationCrudController extends AbstractCrudController
{
    use GenericCrudMethods;

    public static function getEntityFqcn(): string
    {
        return Animation::class;
    }
}
