<?php

namespace App\Controller\Admin;

use App\Entity\SousCategory;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class SousCategoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return SousCategory::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            /*IdField::new('id'),*/
            AssociationField::new('categorie')
                ->setHelp('choisissez la catégorie'),
            TextField::new('label')
                ->setHelp('entrez la sous categorie ici'),
        ];
    }

}
