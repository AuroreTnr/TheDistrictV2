<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('nom'),
            TextField::new('prenom'),
            TextField::new('email')->onlyOnIndex(),
            ChoiceField::new('roles')->setLabel('Permission')->setHelp('Vous pouvez choisir le rôle de cet utilisateur')->setChoices([
                'ROLE_USER' => 'ROLE_USER',
                'ROLE_CHEF' => 'ROLE_CHEF',
                'ROLE_ADMIN' => 'ROLE_ADMIN'
            ])->allowMultipleChoices(),

        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            // the labels used to refer to this entity in titles, buttons, etc.
            ->setEntityLabelInSingular('Utilisateur')
            ->setEntityLabelInPlural('Utilisateurs')
            ->setDefaultSort(['nom' => 'ASC'])

    
    
            // the Symfony Security permission needed to manage the entity
            // (none by default, so you can manage all instances of the entity)
            // ->setEntityPermission('ROLE_EDITOR')
        ;
    }
    
    
}
