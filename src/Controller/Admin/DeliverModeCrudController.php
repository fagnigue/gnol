<?php

namespace App\Controller\Admin;

use App\Entity\DeliverMode;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class DeliverModeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return DeliverMode::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
