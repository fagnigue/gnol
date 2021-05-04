<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;

class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        $imageFile = Field::new('imageFile')->onlyOnForms()->setFormType(VichImageType::class);
        $image = ImageField::new('image_url')->onlyOnIndex()->setBasePath('/uploads/product_image');

        $fields =  [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('label')
                ->setHelp('Entrez le nom du produit'),
            TextField::new('label_desc')
                ->setHelp('Entrez la spécification du produit'),
            TextField::new('bottle_type')
                ->setHelp('Entrez la capacité de la bouteille en cl ex: 75cl'),
            AssociationField::new('souscategorie')
                ->setHelp('Entrez la catégorie du produit'),
            IntegerField::new('quantity')
                ->setHelp('Entrez la quantité de ce produit'),
            MoneyField::new('price')
                ->setCurrency('EUR')
                ->setHelp('Entrez le prix de vente'),
            TextEditorField::new('description'),
        ];

        if ($pageName == Crud::PAGE_INDEX || $pageName == Crud::PAGE_DETAIL) {
            $fields[] = $image;
        } else {
            $fields[] = $imageFile;
        }

        return $fields;
    }

}
