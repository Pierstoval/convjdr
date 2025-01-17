<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use Symfony\Component\HttpFoundation\RedirectResponse;

trait GenericCrudMethods
{
    public function configureCrud(Crud $crud): Crud
    {
        $crud->showEntityActionsInlined();

        return $crud;
    }

    public function configureActions(Actions $actions): Actions
    {
        $actions->add(Crud::PAGE_INDEX, Action::DETAIL);

        return $actions;
    }

    public function getRedirectResponseAfterSave(AdminContext $context, string $action): RedirectResponse
    {
        if (!($this instanceof AbstractCrudController)) {
            throw new \RuntimeException(\sprintf('Trait "%s" used in class "%s" can only be used if the class extends "%s".', self::class, static::class, AbstractCrudController::class));
        }

        if (Action::EDIT === $action) {
            /** @var object $item */
            $item = $context->getEntity()->getInstance();
            $this->addFlash('success', \sprintf('Successfully updated "%s"!', (string) $item));
        }

        return parent::getRedirectResponseAfterSave($context, $action);
    }
}
