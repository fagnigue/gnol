<?php

namespace App\Controller\Admin;

use App\Entity\RelayPoint;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class RelayPointCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return RelayPoint::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('country')
                ->setHelp('choisissez le pays'),
            TextField::new('label')
                ->setHelp('Entrez le point de relais'),
        ];
    }
    
}
