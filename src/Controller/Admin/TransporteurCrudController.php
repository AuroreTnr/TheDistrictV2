<?php

namespace App\Controller\Admin;

use App\Entity\Transporteur;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class TransporteurCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Transporteur::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            // the labels used to refer to this entity in titles, buttons, etc.
            ->setEntityLabelInSingular('Transporteur')
            ->setEntityLabelInPlural('Transporteurs')
        ;
    }


    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('nom')->setLabel('Nom du transporteur'),
            TextareaField::new('description')->setLabel("Description du transporteur"),
            NumberField::new('prix')->setLabel('Prix TTC')
            ->setHelp('Le prix du transporteur TTC, sans le sigle €')
            ->setNumDecimals(2),
        ];
    }
    
}
