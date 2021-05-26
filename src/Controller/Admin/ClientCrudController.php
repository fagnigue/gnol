<?php

namespace App\Controller\Admin;

use App\Entity\Client;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ClientCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Client::class;
    }


    
    public function configureFields(string $pageName): iterable
    {
        return [
            
            TextField::new('firstname', 'Prénom')
                ->setHelp('Entrez le nom'),
            TextField::new('lastname', 'Nom de famille')
                ->setHelp('Entrez le prénom'),
            EmailField::new('email', 'Email')
                ->setHelp("Entrez l'email"),
            AssociationField::new('country')
                ->setHelp('Entrez le pays'),
            TelephoneField::new('telephone', 'Contact')
                ->setHelp('Entrez le numéro de téléphone'),
            TextField::new('password', 'Mot de passe')
                ->onlyOnForms()
                ->setHelp('Entrez le mot de passe'),
            TextField::new('genre')
                ->setHelp('Entrez le genre'),
            TextField::new('adresse')
                ->setHelp("Entrez l'adresse"),
            Field::new('photoFile', 'Photo de profil')
                ->setFormType(VichImageType::class)
                ->onlyOnForms(),
            ImageField::new('photo')
                ->onlyOnIndex()
                ->setBasePath('/uploads/user_image'),
        ];
    }
    
}
