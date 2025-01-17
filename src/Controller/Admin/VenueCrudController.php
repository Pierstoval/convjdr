<?php

namespace App\Controller\Admin;

use App\Entity\Venue;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\KeyValueStore;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Field;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class VenueCrudController extends AbstractCrudController
{
    use GenericCrudMethods;

    public static function getEntityFqcn(): string
    {
        return Venue::class;
    }

    public function configureAssets(Assets $assets): Assets
    {
        return $assets
            ->addCssFile('styles/admin-venue.css')
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            Field\TextField::new('name'),
            Field\TextEditorField::new('address'),
            Field\CollectionField::new('floors'),
        ];
    }

    public function createNewFormBuilder(EntityDto $entityDto, KeyValueStore $formOptions, AdminContext $context): FormBuilderInterface
    {
        return $this->addRootEntityToRelations(parent::createNewFormBuilder($entityDto, $formOptions, $context));
    }

    public function createEditFormBuilder(EntityDto $entityDto, KeyValueStore $formOptions, AdminContext $context): FormBuilderInterface
    {
        return $this->addRootEntityToRelations(parent::createEditFormBuilder($entityDto, $formOptions, $context));
    }

    public function addRootEntityToRelations(FormBuilderInterface $builder): FormBuilderInterface
    {
        return $builder
            ->addEventListener(FormEvents::SUBMIT, function (FormEvent $event): void {
                /** @var Venue $entity */
                $entity = $event->getForm()->getData();
                $entity->refreshNestedRelations();
            })
        ;
    }

}
