<?php

namespace App\Controller\Admin;

use App\Entity\Plat;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
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

        $required = true;
        if ($pageName == 'edit') {
            $required = false;
        }

        return [
            TextField::new('libelle')
                ->setLabel('Titre')
                ->setHelp('Le nom du plat'),
            SlugField::new('slug')->onlyOnForms()
                ->setTargetFieldName('libelle')
                ->setHelp('Le slug est géré automatiquement en fonction du titre de votre plat'),
            ImageField::new('image')
                ->setLabel('Illustration')
                ->setHelp('L\' url du plat')
                ->setUploadedFileNamePattern('[year]-[month]-[day]-[slug].[extension]')
                ->setBasePath('asset/uploads/images/plat/') // chemin ou l image doit etre sauvegarder dans le projet
                ->setUploadDir('public/asset/uploads/images/plat/')  // chemin ou admin doit chercher
                ->setRequired($required),
            NumberField::new('prix')
                ->setHelp('Le prix du plat TTC, sans le sigle euro')
                ->setNumDecimals(2),
            TextEditorField::new('description')->onlyOnForms(),
            AssociationField::new('categorie')
                ->setHelp('Choisissez une catégorie'),
            BooleanField::new('active')
                ->setLabel('En stock'),
            ChoiceField::new('tva')
                ->setLabel('Taux de tva')
                ->setChoices([
                '5,5%' => '5.5',
                '10%' => '10',
                '20%' => '20'
            ])->onlyOnForms(),
            
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
