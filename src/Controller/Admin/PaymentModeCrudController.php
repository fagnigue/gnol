<?php

namespace App\Controller\Admin;

use App\Entity\PaymentMode;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class PaymentModeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return PaymentMode::class;
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
