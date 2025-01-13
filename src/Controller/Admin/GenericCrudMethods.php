<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

trait GenericCrudMethods
{
    public function configureCrud(Crud $crud): Crud
    {
        $crud->showEntityActionsInlined();

        return $crud;
    }
}
