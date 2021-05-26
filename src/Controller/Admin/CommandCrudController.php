<?php

namespace App\Controller\Admin;

use App\Entity\Command;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CommandCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Command::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('client')
                ->onlyOnIndex(),
            AssociationField::new('paymentMode')
                ->onlyOnIndex(),
            AssociationField::new('deliverMode')
                ->onlyOnIndex(),
            AssociationField::new('relaypoint')
                ->onlyOnIndex(),
            NumberField::new('montant', 'Montant total (euro)')
                ->onlyOnIndex(),
            DateField::new('createdAt')
                ->onlyOnIndex(),
            AssociationField::new('status')
                ->onlyOnIndex(),
        ];
    }
    
}
