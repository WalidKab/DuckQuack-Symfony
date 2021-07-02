<?php

namespace App\Controller\Admin;

use App\Entity\Quack;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class QuackCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Quack::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            // ...
            ->remove(Crud::PAGE_INDEX, Action::NEW)
            ->remove(Crud::PAGE_DETAIL, Action::EDIT)
            ->remove(Crud::PAGE_INDEX, Action::EDIT)

            ;
    }

    public function createEntity(string $entityFqcn)
    {
        $quack = new Quack($this->getUser());

        return $quack;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
//            IdField::new('id'),
            TextField::new('content'),
//            TextField::new('author'),
//            TextEditorField::new('picture'),
        ];
    }

}
