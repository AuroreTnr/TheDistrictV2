<?php

namespace App\Controller\Admin;

use App\Entity\Categorie;
use App\Entity\Plat;
use App\Form\CategorieType;
use App\Form\RegisterUserType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PlatCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Plat::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('libelle')->setLabel('Titre')->setHelp('Le nom du plat'),
            TextField::new('prix')->setHelp('Le prix du plat TTC'),
            TextField::new('image')->setLabel('Illustration')->setHelp('L\' url du plat'),
            SlugField::new('slug')->setTargetFieldName('libelle')->setHelp('Le slug est géré automatiquement en fonction du titre de votre plat'),
            TextEditorField::new('description'),
            AssociationField::new('categorie')->setHelp('Choisissez une catégorie'),
            BooleanField::new('active')->setLabel('En stock')->setHelp('Activer ou déactiver en fonction du stock')
            
        ];
    }

    public function configureCrud(Crud $crud): Crud
{
    return $crud
        // the labels used to refer to this entity in titles, buttons, etc.
        ->setEntityLabelInSingular('Plat')
        ->setEntityLabelInPlural('Plats')
        ->setDefaultSort(['libelle' => 'ASC'])



        // the Symfony Security permission needed to manage the entity
        // (none by default, so you can manage all instances of the entity)
        // ->setEntityPermission('ROLE_EDITOR')
    ;
}




    
}
