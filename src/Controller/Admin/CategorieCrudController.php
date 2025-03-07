<?php

namespace App\Controller\Admin;

use App\Entity\Categorie;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use phpDocumentor\Reflection\Types\Boolean;
use Symfony\Component\HttpFoundation\RedirectResponse;

class CategorieCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Categorie::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            // the labels used to refer to this entity in titles, buttons, etc.
            ->setEntityLabelInSingular('Catégorie')
            ->setEntityLabelInPlural('Catégories')
            ->setDefaultSort(['libelle' => 'ASC'])

    
    
            // the Symfony Security permission needed to manage the entity
            // (none by default, so you can manage all instances of the entity)
            // ->setEntityPermission('ROLE_EDITOR')
        ;
    }
    

    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('libelle')->setLabel('Titre')->setHelp('Nom de la catégorie'),
            SlugField::new('slug')->setTargetFieldName('libelle')->setHelp('Le slug est générer en fonction de votre titre'),
            ImageField::new('image')->setLabel('Illustration')->setHelp('L\' url de la catégorie')->setUploadedFileNamePattern('[year]-[month]-[day]-[contenthash].[extension]')->setUploadDir('public/asset/uploads/images/categorie/'),
            BooleanField::new('active')->setLabel('En stock')->setHelp('activer ou deactiver selon vos stocks')
        ];
    }


    
}
